<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Repositories\Contracts\SkateParkRepositoryInterface;
use App\Http\Requests\SkatePark\StoreSkateParkRequest;

class SkateParkController extends Controller
{   
    /**
     * SkateParkController constructor.
     */
    public function __construct(
        protected SkateParkRepositoryInterface $repository,
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

    public function store(StoreSkateParkRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($validated['description'] === null) {
            $validated['description'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
        }

        $skatePark = $this->repository->create($validated);

        return response()->json($skatePark, 201);
    }

    public function update(StoreSkateParkRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        $skatePark = $this->repository->find($id);
        $this->repository->update($skatePark, $validated);

        return response()->json($skatePark);
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Skate park not found'], 404);
        }

        return response()->json(['message' => 'Skate park deleted successfully']);
    }
}