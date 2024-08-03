<?php

namespace App\Repositories\Eloquent;

use App\Models\Rental;
use App\Models\SkatePark;
use App\Repositories\Contracts\RentalRepositoryInterface;

class EloquentRentalRepository implements RentalRepositoryInterface
{
    public function allForSkatePark(SkatePark $skatePark)
    {
        return $skatePark->rentals;
    }

    public function find($id)
    {
        return Rental::findOrFail($id);
    }

    public function createForSkatePark(SkatePark $skatePark, array $data)
    {
        $rental = new Rental($data);
        $rental->skate_park_id = $skatePark->id;
        $skatePark->rentals()->save($rental);

        return $rental;
    }

    public function update(Rental $rental, array $data)
    {
        $rental->update($data);
        return $rental;
    }

    public function delete(Rental $rental)
    {
        $rental->delete();
    }
}