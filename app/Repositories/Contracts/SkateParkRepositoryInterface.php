<?php

namespace App\Repositories\Contracts;

use App\Models\SkatePark;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SkateParkRepositoryInterface
{
    public function all(): Collection;
    public function find($id): Model;
    public function create(array $data): Model;
    public function update(SkatePark $skatePark, array $data): Model|bool;
    public function delete($id): bool;
}