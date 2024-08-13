<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Http\Requests\Rental\StoreRentalRequest;
use Illuminate\Http\JsonResponse;

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
}
