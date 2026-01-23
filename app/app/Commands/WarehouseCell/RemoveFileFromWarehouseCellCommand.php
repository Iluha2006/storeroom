<?php

declare(strict_types=1);

namespace App\Commands\WarehouseCell;

use App\Models\User;
use App\Enums\FileCollectionEnum;
use App\Commands\BaseCommand;
use Illuminate\Http\UploadedFile;


final readonly class RemoveFileFromWarehouseCellCommand extends BaseCommand
{
    public function __construct(
        public int $cellId,
        public int $fileId,
        ?User      $user = null
    )
    {
        parent::__construct($user);
    }
}
