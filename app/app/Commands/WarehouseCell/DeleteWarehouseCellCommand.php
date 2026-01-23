<?php

declare(strict_types=1);

namespace App\Commands\WarehouseCell;

use App\Models\User;
use App\Commands\BaseCommand;


final readonly class DeleteWarehouseCellCommand extends BaseCommand
{
    public function __construct(
        public int $id,
        ?User      $user = null
    )
    {
        parent::__construct($user);
    }
}
