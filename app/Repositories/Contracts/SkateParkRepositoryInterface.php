<?php

namespace App\Repositories\Contracts;

use App\Models\SkatePark;

interface SkateParkRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(SkatePark $skatePark, array $data);
    public function delete(SkatePark $skatePark);
}