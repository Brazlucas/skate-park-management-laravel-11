<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Http\Requests\Rental\StoreRentalRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Rental;
use Carbon\Carbon;
use App\Models\Invoice;

class RentalController extends Controller
{
     /**
     * RentalController constructor.
     */
    public function __construct(
        protected RentalRepositoryInterface $repository,
    ) {
    }

    public function index()
    {
        return response()->json($this->repository->all());
    }

    public function store(StoreRentalRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $rental = $this->repository->create($validated);

        $start = Carbon::parse($validated['start_time']);
        $end = Carbon::parse($validated['end_time']);
        $hours = $end->diffInHours($start);
        $rentValue = ($hours >= 10) ? 500 : $hours * 100;
        $validated['rent_value'] = $rentValue;
        $rental = Rental::create($validated);

        $invoice = Invoice::firstOrCreate(
            [
                'user_id' => $validated['renter_id'],
                'month' => $start->month,
                'year' => $start->year,
            ],
            [
                'amount' => 0,
                'status' => 'pending',
            ]
        );

        $invoice->increment('amount', $rentValue);

        return response()->json($rental, 201);
    }

    public function show($id)
    {
        $rental = $this->repository->find($id);

        if (!$rental) {
            return response()->json(['message' => 'Rental not found'], 404);
        }

        return response()->json($rental);
    }

    public function update(StoreRentalRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        $rental = $this->repository->update($id, $validated);

        if (!$rental) {
            return response()->json(['message' => 'Rental not found'], 404);
        }

        return response()->json($rental);
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Rental not found'], 404);
        }

        return response()->json(['message' => 'Rental deleted successfully']);
    }

    public function rentedParks(Request $request)
    {
        $name = $request->query('renter_name');

        $rentedParks = Rental::where('renter_name', $name)
            ->pluck('skate_park_id');

        return response()->json($rentedParks);
    }

    public function availableHours(Request $request): JsonResponse
    {
        $date = $request->query('date');
        $skateParkId = $request->query('skate_park_id');

        if (!$date || !$skateParkId) {
            return response()->json(['message' => 'Parâmetros ausentes'], 422);
        }

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
        $available = array_map(fn($h) => str_pad($h, 2, '0', STR_PAD_LEFT), $available);

        return response()->json(array_values($available));
    }
    
    public function userRentals(Request $request)
    {
        $userId = $request->user()->id;

        $rentals = Rental::with('skatePark')
            ->where('renter_id', $userId)
            ->orderByDesc('start_time')
            ->get();

        return response()->json($rentals);
    }
}
