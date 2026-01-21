<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\BaseRepositoryInterface;


abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(
        protected Model $model
    ) {}

    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findByIdOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function findByUuid(string $uuid): ?Model
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    public function findByUuidOrFail(string $uuid): Model
    {
        return $this->model->where('uuid', $uuid)->firstOrFail();
    }

    public function findBySlug(string $slug): ?Model
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function findBySlugOrFail(string $slug): Model
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, $columns);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function forceDelete(Model $model): bool
    {
        return $model->forceDelete();
    }

    public function restore(Model $model): bool
    {
        return $model->restore();
    }

    public function existsById(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    public function existsByUuid(string $uuid): bool
    {
        return $this->model->where('uuid', $uuid)->exists();
    }

    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Создать новый экземпляр Query Builder
     */
    protected function newQuery()
    {
        return $this->model->newQuery();
    }
}
