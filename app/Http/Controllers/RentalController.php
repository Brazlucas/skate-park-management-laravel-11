<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Repositories\Contracts\SkateParkRepositoryInterface;

class RentalController extends Controller
{
    protected $rentals;
    protected $skateParks;

    public function __construct(RentalRepositoryInterface $rentals, SkateParkRepositoryInterface $skateParks)
    {
        $this->rentals = $rentals;
        $this->skateParks = $skateParks;
    }

    public function index($skateParkId)
    {
        $skatePark = $this->skateParks->find($skateParkId);
        return $this->rentals->allForSkatePark($skatePark);
    }

    public function show($skateParkId, $rentalId)
    {
        return $this->rentals->find($rentalId);
    }

    public function store(Request $request, $skateParkId)
    {
        $validated = $request->validate([
            'renter_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $skatePark = $this->skateParks->find($skateParkId);
        $rental = $this->rentals->createForSkatePark($skatePark, $validated);

        return response()->json($rental, 201);
    }

    public function update(Request $request, $skateParkId, $rentalId)
    {
        $validated = $request->validate([
            'renter_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $rental = $this->rentals->find($rentalId);
        $this->rentals->update($rental, $validated);

        return response()->json($rental);
    }

    public function destroy($skateParkId, $rentalId)
    {
        $rental = $this->rentals->find($rentalId);
        $this->rentals->delete($rental);

        return response()->json(null, 204);
    }
}
