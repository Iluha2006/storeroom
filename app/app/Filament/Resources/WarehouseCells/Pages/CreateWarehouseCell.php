<?php

namespace App\Filament\Resources\WarehouseCells\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FileCollectionEnum;
use App\Enums\FilesystemDiskEnum;
use App\Filament\Resources\WarehouseCells\WarehouseCellResource;
use App\Models\WarehouseCell;
use Storage;


class CreateWarehouseCell extends CreateRecord
{
    protected static string $resource = WarehouseCellResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Извлекаем файлы из данных
        $plan = $data['plan'] ?? null;
        $photos = $data['photos'] ?? [];

        // Удаляем файлы из массива данных для создания модели
        unset($data['plan'], $data['photos']);

        // Создаем запись
        /** @var WarehouseCell $record */
        $record = static::getModel()::create($data);

        // Обрабатываем план помещения
        if (!empty($plan)) {
            $planArray = is_array($plan) ? $plan : [$plan];

            // Берем последний файл (если загружено несколько)
            $planPath = last($planArray);

            if ($planPath && is_string($planPath)) {
                $this->processPlanFile($record, $planPath);
            }
        }

        // Обрабатываем фотографии
        if (!empty($photos) && is_array($photos)) {
            foreach ($photos as $index => $photoPath) {
                if (is_string($photoPath)) {
                    $this->processPhotoFile($record, $photoPath, $index);
                }
            }
        }

        return $record;
    }

    /**
     * Обработать файл плана помещения
     */
    protected function processPlanFile(WarehouseCell $record, string $filePath): void
    {
        // Получаем полный путь к файлу
        $fullPath = Storage::disk('public')->path($filePath);

        if (file_exists($fullPath)) {
            // Создаем UploadedFile объект
            $uploadedFile = new UploadedFile(
                $fullPath,
                basename($filePath),
                mime_content_type($fullPath),
                filesize($fullPath),
            );

            // Добавляем файл через трейт
            $record->addFile(
                uploadedFile: $uploadedFile,
                disk: FilesystemDiskEnum::Public,
                collection: FileCollectionEnum::Plans,
                metadata: [
                    'uploaded_by' => auth()->id(),
                    'uploaded_at' => now()->toISOString(),
                ]
            );
        }
    }

    /**
     * Обработать файл фотографии
     */
    protected function processPhotoFile(WarehouseCell $record, string $filePath, int $order = 0): void
    {
        // Получаем полный путь к файлу
        $fullPath = Storage::disk('public')->path($filePath);

        if (file_exists($fullPath)) {
            // Создаем UploadedFile объект
            $uploadedFile = new UploadedFile(
                $fullPath,
                basename($filePath),
                mime_content_type($fullPath),
                filesize($fullPath)
            );

            // Добавляем файл через трейт
            $file = $record->addFile(
                uploadedFile: $uploadedFile,
                disk: FilesystemDiskEnum::Public,
                collection: FileCollectionEnum::Photos,
                metadata: [
                    'uploaded_by' => auth()->id(),
                    'uploaded_at' => now()->toISOString(),
                ]
            );

            // Устанавливаем порядок
            $file->update(['order' => $order]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
