<?php

declare(strict_types=1);

namespace App\Handlers\Commands\WarehouseCell;

use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\WarehouseCell;
use App\Enums\FilesystemDiskEnum;
use App\Enums\UserPermissionEnum;
use App\Commands\WarehouseCell\AttachFilesToWarehouseCellCommand;
use App\Handlers\Commands\BaseCommandHandler;
use App\Interfaces\CommandInterface;
use App\Repositories\WarehouseCellRepository;


class AttachFilesToWarehouseCellHandler extends BaseCommandHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    public function authorize(CommandInterface $command): void
    {
        /** @var AttachFilesToWarehouseCellCommand $command */
        $cell = $this->repository->findByIdOrFail($command->id);

        if (!$command->getUser()?->hasPermissionTo(UserPermissionEnum::WarehouseCellEdit)) {
            throw new AuthorizationException('Unauthorized to attach files');
        }
    }

    protected function execute(CommandInterface $command): array
    {
        /** @var AttachFilesToWarehouseCellCommand $command */
        /** @var WarehouseCell $cell */
        $cell = $this->repository->findByIdOrFail($command->id);
        $uploadedFiles = [];

        foreach ($command->files as $file) {
            $uploadedFiles[] = $cell->addFile(
                $file,
                FilesystemDiskEnum::Public,
                $command->collection
            );
        }

        // Сбрасываем кеш
        Cache::tags([
            'warehouse_cells',
        ])->flush();

        return $uploadedFiles;
    }
}
