<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Enums\UserRoleEnum;
use App\Enums\UserPermissionEnum;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Начало настройки ролей и разрешений...');

        // Сбросить кеш ролей и разрешений
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Создание разрешений
        $this->createPermissions();

        // Создание ролей
        $this->createRoles();

        // Назначение разрешений ролям
        $this->assignPermissionsToRoles();

        $this->command->info('✓ Роли и разрешения успешно настроены!');
    }

    /**
     * Создание всех разрешений из enum
     */
    private function createPermissions(): void
    {
        $this->command->info('Создание разрешений...');

        $permissions = UserPermissionEnum::list();
        $created = 0;
        $existing = 0;

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web']
            );

            if ($permission->wasRecentlyCreated) {
                $created++;
            } else {
                $existing++;
            }
        }

        $this->command->info("  ✓ Создано разрешений: {$created}");
        $this->command->info("  ✓ Уже существовало: {$existing}");
    }

    /**
     * Создание всех ролей из enum
     */
    private function createRoles(): void
    {
        $this->command->info('Создание ролей...');

        $roles = UserRoleEnum::list();
        $created = 0;
        $existing = 0;

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'web']
            );

            if ($role->wasRecentlyCreated) {
                $created++;
            } else {
                $existing++;
            }
        }

        $this->command->info("  ✓ Создано ролей: {$created}");
        $this->command->info("  ✓ Уже существовало: {$existing}");
    }

    /**
     * Назначение разрешений ролям
     */
    private function assignPermissionsToRoles(): void
    {
        $this->command->info('Назначение разрешений ролям...');

        // Определяем разрешения для каждой роли
        $rolePermissions = config('rbac.mapping.guards.web', []);

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::findByName($roleName, 'web');

            // Получаем текущие разрешения роли
            $currentPermissions = $role->permissions->pluck('name')->toArray();

            // Находим разрешения, которые нужно добавить
            $permissionsToAdd = array_diff($permissions, $currentPermissions);

            if (!empty($permissionsToAdd)) {
                $role->givePermissionTo($permissionsToAdd);
                $this->command->info("  ✓ Роль '{$roleName}': добавлено " . count($permissionsToAdd) . " разрешений");
            } else {
                $this->command->info("  ✓ Роль '{$roleName}': все разрешения уже назначены");
            }
        }
    }
}
