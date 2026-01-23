<?php

declare(strict_types=1);

namespace App\Handlers\Commands\WarehouseCell;

use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\WarehouseCell;
use App\Enums\UserPermissionEnum;
use App\Commands\WarehouseCell\DeleteWarehouseCellCommand;
use App\Handlers\Commands\BaseCommandHandler;
use App\Interfaces\CommandInterface;
use App\Repositories\WarehouseCellRepository;


class DeleteWarehouseCellHandler extends BaseCommandHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    public function authorize(CommandInterface $command): void
    {
        /** @var DeleteWarehouseCellCommand $command */
        $cell = $this->repository->findByIdOrFail($command->id);

        if (!$command->getUser()?->hasPermissionTo(UserPermissionEnum::WarehouseCellDelete)) {
            throw new AuthorizationException('Unauthorized to delete warehouse cell');
        }
    }

    protected function execute(CommandInterface $command): bool
    {
        /** @var DeleteWarehouseCellCommand $command */
        /** @var WarehouseCell $cell */
        $cell = $this->repository->findByIdOrFail($command->id);
        $objectId = $cell->warehouse_object_id;

        $result = $this->repository->delete($cell);

        // Сбрасываем кеш
        Cache::tags([
            'warehouse_cells',
            'available_cells',
            "warehouse_object:{$objectId}",
        ])->flush();

        return $result;
    }
}
