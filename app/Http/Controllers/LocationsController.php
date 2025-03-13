<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\LocationRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Location\StoreLocationRequest; 

class LocationsController extends Controller
{   
    /**
     * LocationsController constructor.
     */
    public function __construct(
        protected LocationRepositoryInterface $repository,
    ) {
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function store()
    {
        return $this->repository->create(request()->all());
    }

    public function update(StoreLocationRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        $location = $this->repository->find($id);
        $this->repository->update($location, $validated);

        return response()->json($location);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}