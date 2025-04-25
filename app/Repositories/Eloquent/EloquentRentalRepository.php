<?php

namespace App\Repositories\Eloquent;

use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\SkatePark;

class EloquentRentalRepository implements RentalRepositoryInterface
{
    public function createRental(array $data): array|Rental
    {
        $hasConflict = Rental::where('skate_park_id', $data['skate_park_id'])
            ->where(function ($query) use ($data) {
                $query->where('start_time', '<', $data['end_time'])
                    ->where('end_time', '>', $data['start_time']);
            })->exists();

        if ($hasConflict) {
            return ['error' => 'Essa pista já está alugada nesse horário.'];
        }

        $skatePark = SkatePark::findOrFail($data['skate_park_id']);
        $data['skate_park_name'] = $skatePark->name;

        $start = Carbon::parse($data['start_time'])->setTimezone('America/Sao_Paulo');
        $end = Carbon::parse($data['end_time'])->setTimezone('America/Sao_Paulo');
        $hours = $start->diffInHours($end);
        $data['rent_value'] = ($hours >= 10) ? 500 : $hours * 100;

        return Rental::create($data);
    }

    public function getAvailableHours(string $date, int $skateParkId): array
    {
        $maxHour = 20;
        $allHours = range(8, $maxHour);

        if (Carbon::parse($date)->isToday()) {
            $currentHour = now()->hour;
            $allHours = array_filter($allHours, fn($h) => $h > $currentHour);
        }

        $rentals = Rental::where('skate_park_id', $skateParkId)
            ->whereDate('start_time', $date)
            ->get();

        $unavailable = [];

        foreach ($rentals as $rental) {
            $start = Carbon::parse($rental->start_time);
            $end = Carbon::parse($rental->end_time);
            $range = range($start->hour, $end->subMinute()->hour);
            $unavailable = array_merge($unavailable, $range);
        }

        $available = array_filter($allHours, fn($hour) => !in_array($hour, $unavailable));
        return array_map(fn($h) => str_pad($h, 2, '0', STR_PAD_LEFT), $available);
    }

    public function getUserRentals(int $userId): Collection
    {
        return Rental::with('skatePark')
            ->where('renter_id', $userId)
            ->orderByDesc('start_time')
            ->get();
    }

    public function getRentedParksByRenterName(string $name): Collection
    {
        return Rental::where('renter_name', $name)
            ->pluck('skate_park_id');
    }

    public function all(): Collection
    {
        return Rental::all();
    }

    public function find($id): ?Model
    {
        return Rental::find($id);
    }

    public function create(array $data): Model
    {
        return Rental::create($data);
    }

    public function update($rentalId, array $data): Model|bool
    {
        $rental = Rental::findOrFail($rentalId);

        if ($rental) {
            $rental->update($data);
            return $rental;
        }

        return false;
    }

    public function delete($id): bool
    {
        $rental = $this->find($id);

        if ($rental) {
            return $rental->delete();
        }

        return false;
    }
}
