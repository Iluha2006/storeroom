<?php

namespace App\Filament\Resources\WarehouseObjects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\WarehouseObject;
use App\Enums\UserPermissionEnum;


class WarehouseObjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        Checkbox::make('is_active')
                            ->label('Активен'),

                        Select::make('address_id')
                            ->label('Адрес')
                            ->relationship('address', 'street')
                            ->getOptionLabelFromRecordUsing(fn(Address $address) => "{$address->street}, д. {$address->house}"
                                . ($address->building ? ", стр. {$address->building}" : '')
                                . ($address->frame ? ", корп. {$address->frame}" : '')
                            )
                            ->searchable(['street', 'house', 'building', 'frame'])
                            ->preload()
                            ->required()
                            ->native(false)
                            ->placeholder('Выберите адрес')
                            ->noOptionsMessage('Еще нет адресов')
                            ->validationMessages([
                                'required' => 'Нужно выбрать адрес',
                            ])
                            ->visible(fn() => auth()->user()->can(UserPermissionEnum::AddressViewAny->value)),

                        Select::make('organization_id')
                            ->label('Организация')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->placeholder('Выберите организацию')
                            ->noOptionsMessage('Еще нет организаций')
                            ->validationMessages([
                                'required' => 'Нужно выбрать организацию',
                            ])
                            ->visible(fn() => auth()->user()->can(UserPermissionEnum::OrganizationViewAny->value)),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Информация')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название')
                            ->required()
                            ->validationMessages([
                                'required' => 'Необходимо заполнить название',
                            ])
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Символьный код')
                            ->unique(WarehouseObject::class, 'slug', fn($record) => $record),

                        RichEditor::make('description')
                            ->label('Описание'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Дополнительная информация')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Создан')
                            ->dateTime('d.m.Y H:i:s'),

                        TextEntry::make('updated_at')
                            ->label('Обновлен')
                            ->dateTime('d.m.Y H:i:s'),
                    ])
                    ->columns(2)
                    ->hiddenOn('create')
                    ->collapsible(),
            ]);
    }
}
