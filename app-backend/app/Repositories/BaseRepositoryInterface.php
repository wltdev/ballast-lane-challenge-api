<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function getAll(?string $orderBy = null, ?string $order = null): Collection;
    public function findById(int $id): ?Model;
    public function findByField(string $field, mixed $value): ?Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): Model;
    public function delete(int $id): bool;
}
