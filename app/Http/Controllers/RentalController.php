<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Http\Requests\Rental\StoreRentalRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        $result = $this->repository->createRental($validated);

        if (is_array($result) && isset($result['error'])) {
            return response()->json(['message' => $result['error']], 409);
        }

        return response()->json($result, 201);
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
        $parks = $this->repository->getRentedParksByRenterName($name);
        return response()->json($parks);
    }

    public function availableHours(Request $request): JsonResponse
    {
        $date = $request->query('date');
        $skateParkId = $request->query('skate_park_id');

        if (!$date || !$skateParkId) {
            return response()->json(['message' => 'Parâmetros ausentes'], 422);
        }

        $available = $this->repository->getAvailableHours($date, (int)$skateParkId);
        return response()->json(array_values($available));
    }
    
    public function userRentals(Request $request)
    {
        $userId = $request->user()->id;
        $rentals = $this->repository->getUserRentals($userId);
        return response()->json($rentals);
    }
}
