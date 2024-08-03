<?php

namespace App\Repositories\Contracts;

use App\Models\SkatePark;
use App\Models\Rental;

interface RentalRepositoryInterface
{
    public function allForSkatePark(SkatePark $skatePark);
    public function find($id);
    public function createForSkatePark(SkatePark $skatePark, array $data);
    public function update(Rental $rental, array $data);
    public function delete(Rental $rental);
}