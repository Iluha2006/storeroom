<?php

declare(strict_types=1);

namespace App\Commands\WarehouseCell;

use App\Models\User;
use App\Enums\FileCollectionEnum;
use App\Commands\BaseCommand;
use Illuminate\Http\UploadedFile;


final readonly class AttachFilesToWarehouseCellCommand extends BaseCommand
{
    /**
     * @property int $id
     * @property UploadedFile[] $files
     * @property FileCollectionEnum $collection
     * @property User|null $user
     */
    public function __construct(
        public int                $id,
        public array              $files,
        public FileCollectionEnum $collection,
        ?User                     $user = null
    )
    {
        parent::__construct($user);
    }
}
