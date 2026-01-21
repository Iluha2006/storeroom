<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class ModeratorSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Начинаю создавать модераторов...');
        User::factory(5)
            ->withoutTwoFactor()
            ->withoutOrganization()
            ->moderator()
            ->create();
        $this->command->info('✓ Модераторы успешно созданы');
    }
}
