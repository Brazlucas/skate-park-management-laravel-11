<?php

namespace App\Repositories\Eloquent;

use App\Models\Location;
use App\Repositories\Contracts\LocationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentLocationRepository implements LocationRepositoryInterface
{
    public function all(): Collection
    {
        return Location::all(['id', 'city', 'state']);
    }

    public function find($id): Model
    {
        return Location::findOrFail($id);
    }

    public function create(array $data): Model
    {
        return Location::create($data);
    }

    public function update($locationId, array $data): Model|bool
    {
        if ($locationId) {
            $locationId->update($data);
            return $locationId;
        }

        return false;
    }

    public function delete($id): bool
    {
        $location = $this->find($id);

        if ($location) {
            return $location->delete();
        }

        return false;
    }
}