<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationTypeEnum;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю русские организации...');

        $organizations = [
            [
                'name' => 'ООО «СкладЛогистик»',
                'full_name' => 'Общество с ограниченной ответственностью «СкладЛогистик»',
                'inn' => '7712345678',
                'kpp' => '771201001',
                'ogrn' => '1027700132195',
                'address' => 'г. Москва, ул. Нижние Поля, д. 8',
                'phone' => '+7 (495) 123-45-67',
                'email' => 'info@skladlogistik.ru',
            ],
            [
                'name' => 'ООО «Клин Логистик»',
                'full_name' => 'Общество с ограниченной ответственностью «Клин Логистик»',
                'inn' => '5020044567',
                'kpp' => '502001001',
                'ogrn' => '1055003614270',
                'address' => 'г. Клин, ул. Транспортная, д. 5',
                'phone' => '+7 (49624) 6-11-22',
                'email' => 'info@klin-logistik.ru',
            ],
            [
                'name' => 'ООО «Тверь Терминал»',
                'full_name' => 'Общество с ограниченной ответственностью «Тверь Терминал»',
                'inn' => '6950012345',
                'kpp' => '695001001',
                'ogrn' => '1076952020000',
                'address' => 'г. Тверь, Октябрьский проспект, д. 50',
                'phone' => '+7 (4822) 41-22-33',
                'email' => 'info@tver-terminal.ru',
            ],
        ];

        foreach ($organizations as $data) {
            Organization::updateOrCreate(
                ['inn' => $data['inn']],
                array_merge($data, [
                    'status' => OrganizationStatusEnum::Active->value,
                    'type' => OrganizationTypeEnum::Legal->value,
                ])
            );
        }

        $this->command->info('✓ 3 русские организации успешно созданы');
    }
}
