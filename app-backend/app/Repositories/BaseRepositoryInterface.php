<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function findByField(string $field, mixed $value);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
