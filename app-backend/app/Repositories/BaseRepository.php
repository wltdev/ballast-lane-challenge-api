<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(?string $orderBy = null, ?string $order = null): Collection
    {
        $query = $this->model;

        if ($orderBy && $order) {
            $query = $query->orderBy($orderBy, $order);
        }

        return $query->get();
    }

    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findByField(string $field, mixed $value): ?Model
    {
        return $this->model->where($field, $value)->first();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Model
    {
        $record = $this->findById($id);
        if ($record) {
            $record->update($data);
            return $record;
        }

        throw new \Exception('Record not found', 404);
    }

    public function delete(int $id): bool
    {
        $record = $this->findById($id);

        if ($record) {
            return $record->delete();
        }

        return false;
    }
}
