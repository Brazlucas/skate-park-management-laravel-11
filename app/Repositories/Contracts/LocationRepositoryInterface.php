<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface LocationRepositoryInterface
{
    public function all(): Collection;
    public function find($id): Model;
    public function create(array $data): Model;
    public function update($id, array $data): Model|bool;
    public function delete($id): bool;
}
