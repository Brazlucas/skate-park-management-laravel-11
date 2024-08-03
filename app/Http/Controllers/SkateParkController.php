<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\SkateParkRepositoryInterface;

class SkateParkController extends Controller
{
    protected $skateParks;

    public function __construct(SkateParkRepositoryInterface $skateParks)
    {
        $this->skateParks = $skateParks;
    }

    public function index()
    {
        return $this->skateParks->all();
    }

    public function show($id)
    {
        return $this->skateParks->find($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
        ]);

        $skatePark = $this->skateParks->create($validated);

        return response()->json($skatePark, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
        ]);

        $skatePark = $this->skateParks->find($id);
        $this->skateParks->update($skatePark, $validated);

        return response()->json($skatePark);
    }

    public function destroy($id)
    {
        $skatePark = $this->skateParks->find($id);
        $this->skateParks->delete($skatePark);

        return response()->json(null, 204);
    }
}