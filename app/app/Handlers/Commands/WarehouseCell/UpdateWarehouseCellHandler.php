<?php

declare(strict_types=1);

namespace App\Handlers\Commands\WarehouseCell;

use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\WarehouseCell;
use App\Enums\UserPermissionEnum;
use App\Commands\WarehouseCell\UpdateWarehouseCellCommand;
use App\Handlers\Commands\BaseCommandHandler;
use App\Interfaces\CommandInterface;
use App\Repositories\WarehouseCellRepository;


class UpdateWarehouseCellHandler extends BaseCommandHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    public function authorize(CommandInterface $command): void
    {
        /** @var UpdateWarehouseCellCommand $command */
        $cell = $this->repository->findByIdOrFail($command->id);

        if (!$command->getUser()?->hasPermissionTo(UserPermissionEnum::WarehouseCellEdit)) {
            throw new AuthorizationException('Unauthorized to update warehouse cell');
        }
    }

    protected function execute(CommandInterface $command): bool
    {
        /** @var UpdateWarehouseCellCommand $command */
        /** @var WarehouseCell $cell */
        $cell = $this->repository->findByIdOrFail($command->id);
        $result = $this->repository->update($cell, $command->data->toArray());

        // Сбрасываем кеш
        $this->clearCache($cell);

        return $result;
    }

    private function clearCache(WarehouseCell $cell): void
    {
        Cache::tags([
            'warehouse_cells',
            'available_cells',
            "warehouse_object:{$cell->warehouse_object_id}",
        ])->flush();
    }
}
