<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\UserRoleEnum;
use App\Enums\UserPermissionEnum;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SetupRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:setup {--sync : Синхронизировать разрешения ролей}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Настройка ролей и разрешений из Enum';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Настройка ролей и разрешений...');
        $this->newLine();

        // Сбросить кеш
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Создание разрешений
        $this->createPermissions();

        // Создание ролей
        $this->createRoles();

        // Синхронизация разрешений с ролями
        if ($this->option('sync')) {
            $this->syncPermissionsToRoles();
        } else {
            $this->assignPermissionsToRoles();
        }

        $this->newLine();
        $this->info('✅ Роли и разрешения успешно настроены!');

        // Показать статистику
        $this->showStatistics();

        return CommandAlias::SUCCESS;
    }

    /**
     * Создание разрешений из Enum
     */
    private function createPermissions(): void
    {
        $permissions = UserPermissionEnum::cases();

        $this->info('📋 Создание разрешений из Enum...');
        $bar = $this->output->createProgressBar(count($permissions));
        $bar->start();

        $created = 0;
        $existing = 0;

        foreach ($permissions as $permissionEnum) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionEnum->value,
                'guard_name' => 'web',
            ]);

            if ($permission->wasRecentlyCreated) {
                $created++;
            } else {
                $existing++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->line("  ✓ Создано новых: <fg=green>{$created}</>");
        $this->line("  ✓ Уже существовало: <fg=yellow>{$existing}</>");
    }

    /**
     * Создание ролей из Enum
     */
    private function createRoles(): void
    {
        $roles = UserRoleEnum::cases();

        $this->newLine();
        $this->info('👥 Создание ролей из Enum...');

        $created = 0;
        $existing = 0;

        foreach ($roles as $roleEnum) {
            $role = Role::firstOrCreate([
                'name' => $roleEnum->value,
                'guard_name' => 'web',
            ]);

            if ($role->wasRecentlyCreated) {
                $created++;
                $this->line("  ✓ Создана роль: <fg=green>{$roleEnum->label()}</>");
            } else {
                $existing++;
            }
        }

        if ($existing > 0) {
            $this->line("  ✓ Уже существовало ролей: <fg=yellow>{$existing}</>");
        }
    }

    /**
     * Назначение разрешений ролям (добавление новых)
     */
    private function assignPermissionsToRoles(): void
    {
        $this->newLine();
        $this->info('🔐 Назначение разрешений ролям...');

        $rolePermissions = config('rbac.mapping.guards.web', []);

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::findByName($roleName, 'web');
            $roleLabel = UserRoleEnum::from($roleName)->label();

            $currentPermissions = $role->permissions->pluck('name')->toArray();
            $permissionsToAdd = array_diff($permissions, $currentPermissions);

            if (!empty($permissionsToAdd)) {
                $role->givePermissionTo($permissionsToAdd);
                $count = count($permissionsToAdd);
                $this->line("  ✓ <fg=cyan>{$roleLabel}</>: добавлено <fg=green>{$count}</> разрешений");
            } else {
                $this->line("  ✓ <fg=cyan>{$roleLabel}</>: все разрешения уже назначены");
            }
        }
    }

    /**
     * Синхронизация разрешений с ролями (замена существующих)
     */
    private function syncPermissionsToRoles(): void
    {
        $this->newLine();
        $this->warn('⚠️  ВНИМАНИЕ: Синхронизация заменит все существующие разрешения ролей!');

        if (!$this->confirm('Продолжить?', false)) {
            $this->info('Синхронизация отменена.');
            return;
        }

        $this->info('🔄 Синхронизация разрешений с ролями...');

        $rolePermissions = config('rbac.mapping.guards.web', []);

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::findByName($roleName, 'web');
            $roleLabel = UserRoleEnum::from($roleName)->label();

            $role->syncPermissions($permissions);
            $count = count($permissions);
            $this->line("  ✓ <fg=cyan>{$roleLabel}</>: установлено <fg=green>{$count}</> разрешений");
        }
    }

    /**
     * Показать статистику
     */
    private function showStatistics(): void
    {
        $this->newLine();
        $this->info('📊 Статистика:');

        $totalRoles = Role::count();
        $totalPermissions = Permission::count();

        $this->table(
            ['Метрика', 'Значение'],
            [
                ['Всего ролей', $totalRoles],
                ['Всего разрешений', $totalPermissions],
            ]
        );

        $this->newLine();
        $this->info('💡 Полезные команды:');
        $this->line('  php artisan permissions:setup --sync  # Полная синхронизация');
        $this->line('  php artisan permission:cache-reset    # Очистить кеш разрешений');
    }
}
