<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\WarehouseObject;
use App\Models\WarehouseCell;
use App\Enums\WarehouseCellStatusEnum;

class WarehouseCellSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю русские ячейки для складов...');

        if (WarehouseObject::count() === 0) {
            $this->call(WarehouseObjectSeeder::class);
        }

        $objects = WarehouseObject::where('is_active', true)->get();

        foreach ($objects as $object) {
            $this->seedCellsForObject($object);
        }

        $this->command->info('✓ Русские ячейки созданы');
    }

    private function seedCellsForObject(WarehouseObject $object): void
    {
        WarehouseCell::where('warehouse_object_id', $object->id)->forceDelete();

        $cells = [
            [
                'floor' => 1,
                'row' => 1,
                'section' => 1,
                'level' => 1,
                'number' => '1',
                'length' => 200,
                'height' => 250,
                'width' => 150,
                'price' => 3500.00,
                'status' => WarehouseCellStatusEnum::Available,
                'how_to_get_there' => 'Зал А, стеллаж №1, нижний уровень. Подъезд со стороны главных ворот.',
            ],
            [
                'floor' => 1,
                'row' => 1,
                'section' => 1,
                'level' => 2,
                'number' => '2',
                'length' => 200,
                'height' => 250,
                'width' => 150,
                'price' => 3300.00,
                'status' => WarehouseCellStatusEnum::Available,
                'how_to_get_there' => 'Зал А, стеллаж №1, верхний уровень. Грузовой лифт в торце зала.',
            ],
            [
                'floor' => 1,
                'row' => 1,
                'section' => 2,
                'level' => 1,
                'number' => '3',
                'length' => 300,
                'height' => 270,
                'width' => 200,
                'price' => 5500.00,
                'status' => WarehouseCellStatusEnum::Available,
                'how_to_get_there' => 'Зал А, стеллаж №1, секция 2. Проход рядом с рампой разгрузки.',
            ],
            [
                'floor' => 1,
                'row' => 2,
                'section' => 1,
                'level' => 1,
                'number' => '4',
                'length' => 150,
                'height' => 200,
                'width' => 100,
                'price' => 2500.00,
                'status' => WarehouseCellStatusEnum::Reserved,
                'how_to_get_there' => 'Зал Б, стеллаж №2, нижний уровень. Ориентир — синяя разметка прохода.',
            ],
            [
                'floor' => 1,
                'row' => 2,
                'section' => 2,
                'level' => 2,
                'number' => '5',
                'length' => 250,
                'height' => 250,
                'width' => 180,
                'price' => 4800.00,
                'status' => WarehouseCellStatusEnum::Available,
                'how_to_get_there' => 'Зал Б, стеллаж №2, секция 2, верхний уровень. Подъём штабелёром.',
            ],
            [
                'floor' => 1,
                'row' => 3,
                'section' => 1,
                'level' => 1,
                'number' => '6',
                'length' => 400,
                'height' => 300,
                'width' => 250,
                'price' => 9000.00,
                'status' => WarehouseCellStatusEnum::Unavailable,
                'how_to_get_there' => 'Зал В, стеллаж №3, большой формат. Требуется погрузчик для доступа.',
            ],
        ];

        foreach ($cells as $cell) {
            $cell['slug'] = $object->slug . '-' . implode('-', array_filter([
                $cell['floor'],
                $cell['row'],
                $cell['section'],
                $cell['level'],
                $cell['number'],
            ]));

            WarehouseCell::create($cell + [
                'uuid' => (string) Str::uuid(),
                'warehouse_object_id' => $object->id,
            ]);
        }
    }
}
