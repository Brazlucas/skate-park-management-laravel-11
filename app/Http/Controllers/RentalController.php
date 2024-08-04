<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    protected $rentalRepository;

    public function __construct(RentalRepositoryInterface $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    public function index()
    {
        return response()->json($this->rentalRepository->all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'skate_park_id' => 'required|exists:skate_parks,id',
            'renter_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $rental = $this->rentalRepository->create($validatedData);

        return response()->json($rental, 201);
    }

    public function show($id)
    {
        $rental = $this->rentalRepository->find($id);

        if (!$rental) {
            return response()->json(['message' => 'Rental not found'], 404);
        }

        return response()->json($rental);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'skate_park_id' => 'required|exists:skate_parks,id',
            'renter_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $rental = $this->rentalRepository->update($id, $validatedData);

        if (!$rental) {
            return response()->json(['message' => 'Rental not found'], 404);
        }

        return response()->json($rental);
    }

    public function destroy($id)
    {
        $deleted = $this->rentalRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Rental not found'], 404);
        }

        return response()->json(['message' => 'Rental deleted successfully']);
    }
}
