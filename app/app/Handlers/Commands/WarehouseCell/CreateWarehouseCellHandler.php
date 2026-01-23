<?php

declare(strict_types=1);

namespace App\Handlers\Commands\WarehouseCell;

use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\WarehouseCell;
use App\Enums\UserPermissionEnum;
use App\Commands\WarehouseCell\CreateWarehouseCellCommand;
use App\Handlers\Commands\BaseCommandHandler;
use App\Interfaces\CommandInterface;
use App\Repositories\WarehouseCellRepository;


class CreateWarehouseCellHandler extends BaseCommandHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    public function authorize(CommandInterface $command): void
    {
        if (!$command->getUser()?->hasPermissionTo(UserPermissionEnum::WarehouseCellCreate)) {
            throw new AuthorizationException('Unauthorized to create warehouse cell');
        }
    }

    protected function execute(CommandInterface $command): WarehouseCell
    {
        /** @var CreateWarehouseCellCommand $command */
        $cell = $this->repository->create($command->data->toArray());

        // Сбрасываем кеш
        $this->clearCache($cell);

        return $cell;
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
