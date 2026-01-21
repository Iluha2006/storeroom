<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class SuperuserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->warn('Начинаю создавать суперпользователя...');
        $superuser = User::where('email', 'admin@localhost')->first();
        if (!$superuser) {
            User::factory()
                ->active()
                ->withEmail('admin@localhost')
                ->withPassword('qwerty12')
                ->withoutTwoFactor()
                ->withoutOrganization()
                ->superuser()
                ->create();
        }
        $this->command->info('✓ Суперпользователь успешно созданы');
    }
}
