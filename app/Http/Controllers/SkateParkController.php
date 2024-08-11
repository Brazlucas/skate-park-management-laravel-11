<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\SkateParkRepositoryInterface;
use App\Http\Requests\SkatePark\StoreSkateParkRequest;

class SkateParkController extends Controller
{
    protected $skateParkRepository;

    public function __construct(SkateParkRepositoryInterface $skateParks)
    {
        $this->skateParkRepository = $skateParks;
    }

    public function index()
    {
        return $this->skateParkRepository->all();
    }

    public function show($id)
    {
        return $this->skateParkRepository->find($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
        ]);

        $skatePark = $this->skateParkRepository->create($validated);

        return response()->json($skatePark, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
        ]);

        $skatePark = $this->skateParkRepository->find($id);
        $this->skateParkRepository->update($skatePark, $validated);

        return response()->json($skatePark);
    }

    public function destroy($id)
    {
        $deleted = $this->skateParkRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Skate park not found'], 404);
        }

        return response()->json(['message' => 'Skate park deleted successfully']);
    }
}