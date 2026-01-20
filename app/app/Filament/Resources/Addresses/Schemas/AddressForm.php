<?php

namespace App\Filament\Resources\Addresses\Schemas;

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
use App\Enums\UserPermissionEnum;


class AddressForm
{
    protected static function generateSlug($get): string
    {
        $parts = [];

        $fields = [
            'street' => null,
            'house' => null,
            'building' => null,
            'frame' => null,
        ];

        foreach ($fields as $field => $prefix) {
            $value = $get($field);
            if ($value) {
                $slugPart = Str::slug($value);
                if ($prefix) {
                    $slugPart = $prefix . '-' . $slugPart;
                }
                $parts[] = $slugPart;
            }
        }

        return implode('-', $parts);
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        Checkbox::make('is_active')
                            ->label('Активен'),

                        Select::make('city_id')
                            ->label('Город')
                            ->relationship('city', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->placeholder('Выберите город')
                            ->noOptionsMessage('Еще нет городов')
                            ->validationMessages([
                                'required' => 'Нужно выбрать город',
                            ])
                            ->visible(fn() => auth()->user()->can(UserPermissionEnum::CityViewAny->value)),

                        TextInput::make('slug')
                            ->label('Символьный код')
                            ->unique(Address::class, 'slug', fn($record) => $record)
                            ->helperText('Автоматически заполняется из адреса'),

                        TextInput::make('street')
                            ->label('Улица')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                if (filled($state)) {
                                    $set('slug', static::generateSlug($get));
                                }
                            }),

                        TextInput::make('house')
                            ->label('Дом')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                if (filled($state)) {
                                    $set('slug', static::generateSlug($get));
                                }
                            }),

                        TextInput::make('building')
                            ->label('Строение')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                if (filled($state)) {
                                    $set('slug', static::generateSlug($get));
                                }
                            }),

                        TextInput::make('frame')
                            ->label('Корпус')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                if (filled($state)) {
                                    $set('slug', static::generateSlug($get));
                                }
                            }),
                    ])
                    ->columns(2),

                Section::make('Информация')
                    ->schema([
                        RichEditor::make('how_to_get_there')
                            ->label('Как добраться'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Координаты')
                    ->schema([
                        TextInput::make('lat')
                            ->label('Широта')
                            ->required()
                            ->placeholder('55.75582601')
                            ->step(0.00000001)
                            ->numeric()
                            ->minValue('-90')
                            ->maxValue('90')
                            ->suffix('°')
                            ->rules([
                                'required',
                                'numeric',
                                'min:-90',
                                'max:90',
                                'regex:/^-?\d{1,3}(\.\d{1,8})?$/',
                            ])
                            ->validationMessages([
                                'required' => 'Широта обязательна',
                                'numeric' => 'Широта должна быть числом',
                                'min' => 'Широта не может быть меньше -90',
                                'max' => 'Широта не может быть больше 90',
                                'regex' => 'Широта должна быть в формате от -90 до 90 (до 8 цифр после точки)',
                            ])
                            ->helperText('Формат: от -90 до 90, до 8 знаков после точки')
                            ->columnSpan(1),

                        TextInput::make('lon')
                            ->label('Долгота')
                            ->required()
                            ->placeholder('37.61842301')
                            ->step(0.00000001)
                            ->numeric()
                            ->minValue('-180')
                            ->maxValue('180')
                            ->suffix('°')
                            ->rules([
                                'required',
                                'numeric',
                                'min:-180',
                                'max:180',
                                'regex:/^-?\d{1,3}(\.\d{1,8})?$/',
                            ])
                            ->validationMessages([
                                'required' => 'Широта обязательна',
                                'numeric' => 'Широта должна быть числом',
                                'min' => 'Широта не может быть меньше -180',
                                'max' => 'Широта не может быть больше 180',
                                'regex' => 'Широта должна быть в формате от -180 до 180 (до 8 цифр после точки)',
                            ])
                            ->helperText('Формат: от -180 до 180, до 8 знаков после точки')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

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
