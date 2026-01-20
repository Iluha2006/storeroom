<?php

namespace App\Filament\Resources\Roles\Schemas;

use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;


class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название роли')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Используйте snake_case, например: super_admin'),

                        Select::make('guard_name')
                            ->label('Guard')
                            ->options([
                                'web' => 'Web',
                                'api' => 'API',
                            ])
                            ->default('web')
                            ->required()
                            ->native(false),
                    ])
                    ->columns(2),

                Section::make('Разрешения')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label('Выберите разрешения')
                            ->relationship('permissions', 'name')
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable()
                            ->gridDirection('row'),
                    ]),

                Section::make('Дополнительная информация')
                    ->schema([
                        TextEntry::make('users_count')
                            ->label('Количество пользователей')
                            ->state(fn(?Role $record): string => $record ? $record->users()->count() : '0'),

                        TextEntry::make('created_at')
                            ->label('Создана')
                            ->state(fn(Role $record): ?string => $record->created_at?->format('d.m.Y H:i')),

                        TextEntry::make('updated_at')
                            ->label('Обновлена')
                            ->state(fn(Role $record): ?string => $record->updated_at?->format('d.m.Y H:i')),
                    ])
                    ->columns(3)
                    ->hiddenOn('create')
                    ->collapsible(),
            ]);
    }
}
