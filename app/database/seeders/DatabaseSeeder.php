<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'status' => UserStatusEnum::Active,
            'name' => 'Test',
            'email' => 'test@test.local',
            'password' => Hash::make('qwerty12'),
        ]);

        $user->assignRole(UserRoleEnum::Superuser);
    }
}
