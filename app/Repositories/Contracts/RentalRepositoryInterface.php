<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RentalRepositoryInterface
{
    public function all(): Collection;
    public function find($id): ?Model;
    public function create(array $data);
    public function update($id, array $data): Model|bool;
    public function delete($id): bool;
    public function createRental(array $data): array|Model;
    public function getAvailableHours(string $date, int $skateParkId): array;
    public function getUserRentals(int $userId): Collection;
    public function getRentedParksByRenterName(string $name): Collection;
}
