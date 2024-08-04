<?php

namespace App\Repositories\Eloquent;

use App\Models\SkatePark;
use App\Repositories\Contracts\SkateParkRepositoryInterface;

class EloquentSkateParkRepository implements SkateParkRepositoryInterface
{
    public function all()
    {
        return SkatePark::all();
    }

    public function find($id)
    {
        return SkatePark::findOrFail($id);
    }

    public function create(array $data)
    {
        return SkatePark::create($data);
    }

    public function update(SkatePark $skatePark, array $data)
    {
        $skatePark->update($data);
        return $skatePark;
    }

    public function delete(SkatePark $skatePark)
    {
        $skatePark->delete();
    }
}