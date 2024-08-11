<?php

namespace App\Repositories\Eloquent;

use App\Models\SkatePark;
use App\Repositories\Contracts\SkateParkRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentSkateParkRepository implements SkateParkRepositoryInterface
{
    public function all(): Collection
    {
        return SkatePark::all();
    }

    public function find($id): Model
    {
        return SkatePark::findOrFail($id);
    }

    public function create(array $data): Model
    {
        return SkatePark::create($data);
    }

    public function update(SkatePark $skateParkId, array $data): Model|bool
    {
        if ($skateParkId) {
            $skateParkId->update($data);
            return $skateParkId;
        }

        return false;
    }

    public function delete($id): bool
    {
        $skatePark = $this->find($id);

        if ($skatePark) {
            return $skatePark->delete();
        }

        return false;
    }
}