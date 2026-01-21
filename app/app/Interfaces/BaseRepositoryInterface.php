<?php

declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


interface BaseRepositoryInterface
{
    public function findById(int $id): ?Model;

    public function findByIdOrFail(int $id): Model;

    public function findByUuid(string $uuid): ?Model;

    public function findByUuidOrFail(string $uuid): Model;

    public function findBySlug(string $slug): ?Model;

    public function findBySlugOrFail(string $slug): Model;

    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function create(array $data): Model;

    public function update(Model $model, array $data): bool;

    public function delete(Model $model): bool;

    public function forceDelete(Model $model): bool;

    public function restore(Model $model): bool;

    public function existsById(int $id): bool;

    public function existsByUuid(string $uuid): bool;

    public function count(): int;
}
