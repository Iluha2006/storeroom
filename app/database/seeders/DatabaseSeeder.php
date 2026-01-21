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
        $this->call([
            RolesAndPermissionsSeeder::class,
            SuperuserSeeder::class,
            ModeratorSeeder::class,
            UserSeeder::class,
            OrganizationSeeder::class,
            PartnerSeeder::class,
            CitySeeder::class,
            AddressSeeder::class,
            WarehouseObjectSeeder::class,
            WarehouseCellSeeder::class,
        ]);
    }
}
