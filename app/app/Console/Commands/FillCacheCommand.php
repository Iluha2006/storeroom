<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CityCacheService;
use App\Services\WarehouseCellService;

class FillCacheCommand extends Command
{
    protected $signature = 'cache:fill';
    protected $description = 'Fill Redis cache with data from database';

    public function handle()
    {
        $this->info('Filling warehouse cells cache...');

    $cells = app(WarehouseCellService::class)->getAllCells();

    $this->info("Found cells: {$cells->count()}");

    if ($cells->isNotEmpty()) {
        $this->info('First cell sample:');
        $this->table(
            ['ID', 'Slug', 'Status', 'Object ID', 'Price'],
            $cells->take(3)->map(fn($c) => [
                $c->id,
                $c->slug,
                $c->status->value ?? 'null',
                $c->warehouse_object_id,
                $c->price
            ])->toArray()
        );
    } else {
        $this->warn('⚠️ No cells found! Check filters:');
        $this->info('- Status filter: Available only (' . \App\Enums\WarehouseCellStatusEnum::Available->value . ')');
        $this->info('- Object filter: is_active = true');
        $this->info('- Check if warehouse_cells table has data');
    }

    $this->info('Cache filled successfully!');
    }
}