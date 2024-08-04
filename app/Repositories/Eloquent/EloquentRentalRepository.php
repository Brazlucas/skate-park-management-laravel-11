<?php

namespace App\Repositories\Eloquent;

use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;

class EloquentRentalRepository implements RentalRepositoryInterface
{
    public function all()
    {
        return Rental::all();
    }

    public function find($id)
    {
        return Rental::find($id);
    }

    public function create(array $data)
    {
        return Rental::create($data);
    }

    public function update($id, array $data)
    {
        $rental = Rental::find($id);

        if ($rental) {
            $rental->update($data);
            return $rental;
        }

        return null;
    }

    public function delete($id)
    {
        $rental = Rental::find($id);

        if ($rental) {
            return $rental->delete();
        }

        return false;
    }
}
