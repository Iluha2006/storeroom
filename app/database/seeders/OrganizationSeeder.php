<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Начинаю создавать организации...');
        Organization::factory(20)
            ->create();
        $this->command->info('✓ Организации успешно созданы');
    }
}
