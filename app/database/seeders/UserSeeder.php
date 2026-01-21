<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Начинаю создавать пользователей...');
        User::factory(50)
            ->withoutTwoFactor()
            ->withoutOrganization()
            ->user()
            ->create();
        $this->command->info('✓ Пользователи успешно созданы');
    }
}
