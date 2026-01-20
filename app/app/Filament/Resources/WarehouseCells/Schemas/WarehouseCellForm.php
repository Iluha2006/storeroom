<?php

namespace App\Filament\Resources\WarehouseCells\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Enums\UserPermissionEnum;
use App\Enums\WarehouseCellStatusEnum;
use App\Enums\FileCollectionEnum;
use App\Enums\FilesystemDiskEnum;


class WarehouseCellForm
{
    protected static function generateSlug($get): string
    {
        $parts = [];

        $fields = [
            'floor' => null,
            'row' => null,
            'section' => null,
            'frame' => null,
            'level' => null,
            'number' => null,
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
                        Select::make('status')
                            ->label('Статус')
                            ->options(WarehouseCellStatusEnum::class)
                            ->required()
                            ->default(WarehouseCellStatusEnum::Unavailable)
                            ->native(false),

                        Select::make('warehouse_object_id')
                            ->label('Объект')
                            ->relationship('object', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->placeholder('Выберите объект')
                            ->noOptionsMessage('Еще нет объектов')
                            ->validationMessages([
                                'required' => 'Нужно выбрать объект',
                            ])
                            ->visible(fn() => auth()->user()->can(UserPermissionEnum::WarehouseObjectViewAny->value)),

                        TextInput::make('number')
                            ->label('Номер ячейки')
                            ->required()
                            ->integer()
                            ->validationMessages([
                                'required' => 'Нужно указать номер ячейки',
                            ])
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                if (filled($state)) {
                                    $set('slug', static::generateSlug($get));
                                }
                            }),

                        TextInput::make('price')
                            ->label('Цена')
                            ->required()
                            ->validationMessages([
                                'required' => 'Нужно указать цену',
                            ])
                            ->step(0.01)
                            ->numeric()
                            ->minValue('0')
                            ->suffix('₽')
                            ->rules([
                                'required',
                                'numeric',
                                'min:0',
                                'regex:/^\d+(\.\d{1,2})?$/',
                            ])
                            ->validationMessages([
                                'required' => 'Нужно указать цену',
                                'numeric' => 'Цена должна быть числом',
                                'min' => 'Цена не может быть меньше 0',
                                'regex' => 'Максимум 2 знака после точки (например: 100, 99.99, 0.5)',
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Параметры')
                    ->schema([
                        TextInput::make('floor')
                            ->label('Этаж')
                            ->integer()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                if (filled($state)) {
                                    $set('slug', static::generateSlug($get));
                                }
                            }),

                        TextInput::make('row')
                            ->label('Ряд')
                            ->integer()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                if (filled($state)) {
                                    $set('slug', static::generateSlug($get));
                                }
                            }),

                        TextInput::make('section')
                            ->label('Секция')
                            ->integer()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                if (filled($state)) {
                                    $set('slug', static::generateSlug($get));
                                }
                            }),

                        TextInput::make('level')
                            ->label('Уровень')
                            ->integer()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                if (filled($state)) {
                                    $set('slug', static::generateSlug($get));
                                }
                            }),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Габариты')
                    ->schema([
                        TextInput::make('length')
                            ->label('Длинна, см')
                            ->required()
                            ->integer()
                            ->validationMessages([
                                'required' => 'Нужно указать длину',
                            ]),

                        TextInput::make('height')
                            ->label('Высота, см')
                            ->required()
                            ->integer()
                            ->validationMessages([
                                'required' => 'Нужно указать высоту',
                            ]),

                        TextInput::make('width')
                            ->label('Ширина, см')
                            ->required()
                            ->integer()
                            ->validationMessages([
                                'required' => 'Нужно указать ширину',
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('План помещения')
                    ->description('Загрузите схему или план расположения ячейки')
                    ->schema([
                        FileUpload::make('plan')
                            ->label('План помещения')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatioOptions([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->directory(FileCollectionEnum::Plans->value)
                            ->disk(FilesystemDiskEnum::Public->value)
                            ->visibility('public')
                            ->maxSize(5120) // 5MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Изображение плана помещения (максимум 5MB)')
                            ->downloadable()
                            ->openable()
                            ->previewable()
                            ->imagePreviewHeight('400')
                            ->automaticallyResizeImagesMode('contain')
                            ->automaticallyResizeImagesToWidth('1920')
                            ->automaticallyResizeImagesToHeight('1080')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(false),

                Section::make('Фотографии')
                    ->description('Загрузите фотографии ячейки. Можно изменять порядок перетаскиванием.')
                    ->schema([
                        FileUpload::make('photos')
                            ->label('Галерея фотографий')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->reorderable()
                            ->appendFiles()
                            ->directory(FileCollectionEnum::Photos->value)
                            ->disk(FilesystemDiskEnum::Public->value)
                            ->visibility('public')
                            ->maxSize(5120) // 5MB
                            ->maxFiles(10)
                            ->minFiles(0)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('До 10 фотографий (максимум 5MB каждая). Перетащите для изменения порядка.')
                            ->downloadable()
                            ->openable()
                            ->previewable()
                            ->imagePreviewHeight('200')
                            ->automaticallyResizeImagesMode('cover')
                            ->automaticallyResizeImagesToWidth('1920')
                            ->automaticallyResizeImagesToHeight('1080')
                            ->panelLayout('grid')
                            ->removeUploadedFileButtonPosition('top-right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->columnSpanFull()
                            ->hint('Изображения можно сортировать')
                            ->hintIcon('heroicon-m-arrows-up-down')
                            ->hintColor('success'),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(false),

                Section::make('Информация')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Символьный код'),

                        RichEditor::make('how_to_get_there')
                            ->label('Как добраться')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory(FileCollectionEnum::Documents->value)
                            ->fileAttachmentsVisibility('public')
                            ->columnSpanFull()
                            ->helperText('Опишите маршрут к ячейке. Можно добавлять изображения и файлы через кнопку "Прикрепить файлы"'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Дополнительная информация')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Создана')
                            ->dateTime('d.m.Y H:i:s'),

                        TextEntry::make('updated_at')
                            ->label('Обновлена')
                            ->dateTime('d.m.Y H:i:s'),
                    ])
                    ->columns(2)
                    ->hiddenOn('create')
                    ->collapsible(),
            ]);
    }
}
