<?php

namespace App\Filament\Resources\Organizations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Models\Organization;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationTypeEnum;


class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Основная информация')
                ->schema([
                    Select::make('status')
                        ->label('Статус')
                        ->options(OrganizationStatusEnum::class)
                        ->required()
                        ->default(OrganizationStatusEnum::Inactive)
                        ->native(false)
                        ->helperText('Статус договора с организацией'),

                    Select::make('type')
                        ->label('Тип')
                        ->options(OrganizationTypeEnum::class)
                        ->required()
                        ->default(OrganizationTypeEnum::Legal)
                        ->native(false)
                        ->helperText('Юридическое лицо или ИП'),

                    TextInput::make('name')
                        ->label('Название')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('ООО "Компания"')
                        ->autocomplete(false),

                    TextInput::make('full_name')
                        ->label('Полное наименование')
                        ->maxLength(255)
                        ->placeholder('Общество с ограниченной ответственностью "Компания"')
                        ->helperText('Полное юридическое название')
                        ->autocomplete(false),
                ])
                ->columns(2)
                ->collapsible(),

            Section::make('Реквизиты')
                ->schema([
                    TextInput::make('inn')
                        ->label('ИНН')
                        ->minLength(10)
                        ->maxLength(12)
                        ->placeholder('0123456789')
                        ->helperText('10 цифр для юр. лиц, 12 для ИП')
                        ->rules([
                            'nullable',
                            'regex:/^\d{10}$|^\d{12}$/',
                            'min:10',
                            'max:12',
                        ])
                        ->validationMessages([
                            'regex' => 'ИНН должен содержать ровно 10 или 12 цифр',
                            'min' => 'Минимальная длинна 10 цифр',
                            'max' => 'Максимальная длинна 12 цифр',
                        ]),

                    TextInput::make('kpp')
                        ->label('КПП')
                        ->length(9)
                        ->minLength(9)
                        ->maxLength(9)
                        ->placeholder('012345678')
                        ->helperText('Только для юридических лиц (9 цифр)')
                        ->rules([
                            'nullable',
                            'regex:/^\d{9}$/',
                            'min:9',
                            'max:9',
                        ])
                        ->validationMessages([
                            'regex' => 'КПП должен содержать ровно 9 цифр',
                            'min' => 'Допустимая длинна 9 цифр',
                            'max' => 'Допустимая длинна 9 цифр',
                        ]),

                    TextInput::make('ogrn')
                        ->label('ОГРН/ОГРНИП')
                        ->minLength(13)
                        ->maxLength(15)
                        ->placeholder('012345678901234')
                        ->helperText('13 цифр для ОГРН, 15 для ОГРНИП')
                        ->rules([
                            'nullable',
                            'regex:/^\d{13}$|^\d{15}$/',
                            'min:13',
                            'max:15',
                        ])
                        ->validationMessages([
                            'regex' => 'ОГРН должен содержать ровно 13 или 15 цифр',
                            'min' => 'Минимальная длинна 13 цифр',
                            'max' => 'Максимальная длинна 15 цифр',
                        ]),
                ])
                ->columns(3)
                ->collapsible(),

            Section::make('Контакты')
                ->schema([
                    TextInput::make('address')
                        ->label('Юридический адрес')
                        ->maxLength(255)
                        ->placeholder('г. Москва, ул. Примерная, д. 1')
                        ->columnSpanFull()
                        ->autocomplete(false),

                    TextInput::make('phone')
                        ->label('Телефон')
                        ->tel()
                        ->maxLength(255)
                        ->placeholder('+7 (999) 123-45-67')
                        ->autocomplete(false),

                    TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->maxLength(255)
                        ->placeholder('info@example.com')
                        ->autocomplete(false),
                ])
                ->columns(2)
                ->collapsible(),

            Section::make('Дополнительная информация')
                ->schema([
                    TextEntry::make('created_at')
                        ->label('Создана')
                        ->state(fn(Organization $record): ?string => $record->created_at?->format('d.m.Y H:i')),

                    TextEntry::make('updated_at')
                        ->label('Обновлена')
                        ->state(fn(Organization $record): ?string => $record->updated_at?->format('d.m.Y H:i')),

                    TextEntry::make('users_count')
                        ->label('Пользователей')
                        ->state(fn(Organization $record): string => $record->users()->count()),
                ])
                ->columns(3)
                ->hiddenOn('create')
                ->collapsible()
                ->collapsed(),
        ]);
    }
}
