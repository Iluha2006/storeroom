<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseCell;
use App\Models\WarehouseObject;

class WarehouseCellSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Начинаю создавать ячейки...');
        if (WarehouseObject::count() === 0) {
            $this->call(WarehouseObjectSeeder::class);
        }
        $objects = WarehouseObject::all();
        $totalCells = 0;
        $numberOfCells = 100;
        foreach ($objects as $object) {
            for ($i = 0; $i < $numberOfCells; $i++) {
                $cellNumber = $i + 1;
                WarehouseCell::factory()
                    ->withObject($object->id)
                    ->withNumber($cellNumber)
                    ->create();
                $totalCells++;
            }
            if ($totalCells % 1000 === 0) {
                $this->command->info("Создано ячеек: {$totalCells}");
            }
        }
        $this->command->info('✓ Ячейки успешно созданы');
    }
}
