<?php

declare(strict_types=1);

namespace App\Commands\WarehouseCell;

use App\Models\User;
use App\Data\WarehouseCellData;
use App\Commands\BaseCommand;


final readonly class CreateWarehouseCellCommand extends BaseCommand
{
    public function __construct(
        public WarehouseCellData $data,
        ?User                    $user = null
    )
    {
        parent::__construct($user);
    }
}
