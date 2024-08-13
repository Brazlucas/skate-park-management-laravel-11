<?php

namespace App\Repositories\Eloquent;

use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentRentalRepository implements RentalRepositoryInterface
{
    public function all(): Collection
    {
        return Rental::all();
    }

    public function find($id): Model
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
