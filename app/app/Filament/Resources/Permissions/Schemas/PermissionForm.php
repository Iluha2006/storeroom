<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Spatie\Permission\Models\Permission;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Enums\UserRoleEnum;


class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название разрешения')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Используйте формат: entity.action, например: user.create'),

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

                Section::make('Роли')
                    ->schema([
                        CheckboxList::make('roles')
                            ->label('Назначить ролям')
                            ->relationship('roles', 'name')
                            ->formatStateUsing(fn($state) => UserRoleEnum::tryFrom($state['name'])?->label() ?? $state['name'])
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable(),
                    ]),

                Section::make('Дополнительная информация')
                    ->schema([
                        TextEntry::make('roles_count')
                            ->label('Количество ролей')
                            ->state(fn(?Permission $record): string => $record ? $record->roles()->count() : '0'),

                        TextEntry::make('users_count')
                            ->label('Прямых пользователей')
                            ->state(fn(?Permission $record): string => $record ? $record->users()->count() : '0'),

                        TextEntry::make('created_at')
                            ->label('Создано')
                            ->state(fn(Permission $record): ?string => $record->created_at?->format('d.m.Y H:i:s')),

                        TextEntry::make('updated_at')
                            ->label('Обновлено')
                            ->state(fn(Permission $record): ?string => $record->updated_at?->format('d.m.Y H:i:s')),
                    ])
                    ->columns(4)
                    ->hiddenOn('create')
                    ->collapsible(),
            ]);
    }
}
