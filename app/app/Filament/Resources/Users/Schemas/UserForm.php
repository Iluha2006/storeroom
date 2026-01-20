<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Enums\UserStatusEnum;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\DateTimePicker;
use Spatie\Permission\Models\Role;
use App\Enums\UserRoleEnum;
use App\Enums\UserPermissionEnum;
use Filament\Forms\Components\CheckboxList;
use App\Models\User;
use Illuminate\Validation\Rules\RequiredIf;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        Select::make('status')
                            ->label('Статус')
                            ->options(UserStatusEnum::class)
                            ->required()
                            ->default(UserStatusEnum::Active)
                            ->native(false),

                        TextInput::make('name')
                            ->label('Имя')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('lastname')
                            ->label('Фамилия')
                            ->maxLength(100),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Телефон')
                            ->tel()
                            ->maxLength(255),

                        Select::make('organization_id')
                            ->label('Организация')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->placeholder('Выберите организацию')
                            ->helperText('Выберите организацию пользователя если у него роль "Партнер"')
                            ->noOptionsMessage('Еще нет организаций'),
                    ])
                    ->columns(2),

                Section::make('Безопасность')
                    ->schema([
                        TextInput::make('password')
                            ->label('Пароль')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->revealable()
                            ->helperText('Оставьте пустым, чтобы не менять пароль'),

                        DateTimePicker::make('email_verified_at')
                            ->label('Email подтвержден')
                            ->displayFormat('d.m.Y H:i')
                            ->native(false),

                        DateTimePicker::make('phone_verified_at')
                            ->label('Телефон подтвержден')
                            ->displayFormat('d.m.Y H:i')
                            ->native(false),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Роли и разрешения')
                    ->schema([
                        Select::make('roles')
                            ->label('Роли')
                            ->options(UserRoleEnum::forForm())
                            ->relationship('roles', 'name')
                            ->getOptionLabelFromRecordUsing(fn(Role $record) => UserRoleEnum::tryFrom($record->name)?->label() ?? $record->name)
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->helperText('Выберите одну или несколько ролей для пользователя')
                            ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserRoleEdit->value)),

                        CheckboxList::make('permissions')
                            ->label('Дополнительные разрешения')
                            ->relationship('permissions', 'name')
                            ->options(UserPermissionEnum::forForm())
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable()
                            ->gridDirection('row')
                            ->helperText('Разрешения в дополнение к ролям (опционально)')
                            ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserPermissionEdit->value)),
                    ])
                    ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserRoleView->value))
                    ->columns(1)
                    ->collapsed(fn(string $context): bool => $context === 'edit')
                    ->collapsible(),

                Section::make('Дополнительная информация')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Создан')
                            ->state(fn(User $record): ?string => $record->created_at?->format('d.m.Y H:i')),

                        TextEntry::make('updated_at')
                            ->label('Обновлен')
                            ->state(fn(User $record): ?string => $record->updated_at?->format('d.m.Y H:i')),

                        TextEntry::make('last_login_at')
                            ->label('Последний вход')
                            ->state(fn(User $record): ?string => $record->last_login_at?->format('d.m.Y H:i') ?? 'Никогда'),
                    ])
                    ->columns(3)
                    ->hiddenOn('create')
                    ->collapsed(fn(string $context): bool => $context === 'edit')
                    ->collapsible(),
            ]);
    }
}
