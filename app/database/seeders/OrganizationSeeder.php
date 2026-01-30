<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Enums\OrganizationStatusEnum;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю 3 организации...');

        Organization::factory()
            ->state(['status' => OrganizationStatusEnum::Active->value])
            ->create();
        Organization::factory()
            ->state(['status' => OrganizationStatusEnum::Active->value])
            ->create();
        Organization::factory()
            ->state(['status' => OrganizationStatusEnum::Active->value])
            ->create();

        $this->command->info('✓ 3 активные организации успешно созданы');
    }
}