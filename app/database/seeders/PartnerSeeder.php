<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Начинаю создавать партнеров...');
        if (Organization::count() === 0) {
            $this->call(OrganizationSeeder::class);
        }
        $organizations = Organization::all();
        foreach ($organizations as $organization) {
            User::factory()
                ->withOrganization($organization->id)
                ->withoutTwoFactor()
                ->moderator()
                ->create();
        }
        $this->command->info('✓ Партнеры успешно созданы');
    }
}
