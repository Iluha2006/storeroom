<?php

declare(strict_types=1);

namespace App\Commands\WarehouseCell;

use App\Models\User;
use App\Data\WarehouseCellData;
use App\Commands\BaseCommand;


final readonly class UpdateWarehouseCellCommand extends BaseCommand
{
    public function __construct(
        public int               $id,
        public WarehouseCellData $data,
        ?User                    $user = null
    )
    {
        parent::__construct($user);
    }
}
