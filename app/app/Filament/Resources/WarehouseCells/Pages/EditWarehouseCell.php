<?php

namespace App\Filament\Resources\WarehouseCells\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FileCollectionEnum;
use App\Filament\Resources\WarehouseCells\WarehouseCellResource;
use Illuminate\Http\UploadedFile;
use App\Enums\FilesystemDiskEnum;
use App\Models\WarehouseCell;
use Storage;


class EditWarehouseCell extends EditRecord
{
    protected static string $resource = WarehouseCellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Загружаем существующий план
        $plan = $this->record->plan;
        if ($plan) {
            // Возвращаем относительный путь для Filament
            $data['plan'] = [$plan->path];
        }

        // Загружаем существующие фотографии
        $photos = $this->record->photos;
        if ($photos->isNotEmpty()) {
            // Возвращаем массив путей в правильном порядке
            $data['photos'] = $photos->sortBy('order')->pluck('path')->toArray();
        }

        return $data;
    }

    /**
     * @param WarehouseCell $record
     * @param array $data
     * @return Model
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $plan = $data['plan'] ?? null;
        $photos = $data['photos'] ?? [];

        unset($data['plan'], $data['photos']);

        $record->update($data);

        // Обрабатываем план
        if (!empty($plan)) {
            $this->handlePlanUpdate($record, is_array($plan) ? $plan : [$plan]);
        } else {
            // Если план удален (пустой массив), удаляем файл
            $record->clearFiles(FileCollectionEnum::Plans);
        }

        // Обрабатываем фотографии
        if (!empty($photos)) {
            $this->handlePhotosUpdate($record, is_array($photos) ? $photos : [$photos]);
        } else {
            // Если все фото удалены, очищаем коллекцию
            $record->clearFiles(FileCollectionEnum::Photos);
        }

        return $record;
    }

    /**
     * Обработать обновление плана
     */
    protected function handlePlanUpdate(WarehouseCell $record, array $planData): void
    {
        // Получаем текущий план
        $currentPlan = $record->plan;
        $currentPlanPath = $currentPlan?->path;

        // Фильтруем новые файлы (те, которых нет в текущих)
        $newFiles = array_filter($planData, function($item) use ($currentPlanPath) {
            return is_string($item) && $item !== $currentPlanPath;
        });

        // Если есть новые файлы - заменяем план
        if (!empty($newFiles)) {
            // Удаляем старый план
            $record->clearFiles(FileCollectionEnum::Plans);

            // Берем последний загруженный файл
            $filePath = last($newFiles);

            // Проверяем, это новый файл или существующий
            if (!str_starts_with($filePath, 'http')) {
                $this->processPlanFile($record, $filePath);
            }
        } elseif (empty($planData) && $currentPlan) {
            // План был удален пользователем
            $record->clearFiles(FileCollectionEnum::Plans);
        }
    }

    /**
     * Обработать обновление фотографий
     */
    protected function handlePhotosUpdate(WarehouseCell $record, array $photosData): void
    {
        // Получаем текущие фотографии
        $currentPhotos = $record->photos;
        $currentPhotoPaths = $currentPhotos->pluck('path')->toArray();

        // Разделяем на существующие и новые файлы
        $existingPaths = [];
        $newFiles = [];

        foreach ($photosData as $item) {
            if (is_string($item)) {
                if (in_array($item, $currentPhotoPaths)) {
                    // Существующий файл
                    $existingPaths[] = $item;
                } else {
                    // Новый файл
                    $newFiles[] = $item;
                }
            }
        }

        // Удаляем фото, которых больше нет в списке
        $photosToDelete = $currentPhotos->filter(function($photo) use ($existingPaths) {
            return !in_array($photo->path, $existingPaths);
        });

        foreach ($photosToDelete as $photo) {
            // Удаляем физический файл
            Storage::disk($photo->disk->value)->delete($photo->path);
            // Удаляем запись
            $photo->delete();
        }

        // Обновляем порядок существующих фото
        foreach ($existingPaths as $index => $path) {
            $photo = $currentPhotos->firstWhere('path', $path);
            if ($photo && $photo->order !== $index) {
                $photo->update(['order' => $index]);
            }
        }

        // Добавляем новые фото
        if (!empty($newFiles)) {
            $startOrder = count($existingPaths);

            foreach ($newFiles as $index => $filePath) {
                if (!str_starts_with($filePath, 'http')) {
                    $this->processPhotoFile($record, $filePath, $startOrder + $index);
                }
            }
        }
    }

    /**
     * Обработать файл плана
     */
    protected function processPlanFile(WarehouseCell $record, string $filePath): void
    {
        $fullPath = Storage::disk('public')->path($filePath);

        if (file_exists($fullPath)) {
            $uploadedFile = new UploadedFile(
                $fullPath,
                basename($filePath),
                mime_content_type($fullPath),
                filesize($fullPath),
            );

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
        $fullPath = Storage::disk('public')->path($filePath);

        if (file_exists($fullPath)) {
            $uploadedFile = new UploadedFile(
                $fullPath,
                basename($filePath),
                mime_content_type($fullPath),
                filesize($fullPath)
            );

            $file = $record->addFile(
                uploadedFile: $uploadedFile,
                disk: FilesystemDiskEnum::Public,
                collection: FileCollectionEnum::Photos,
                metadata: [
                    'uploaded_by' => auth()->id(),
                    'uploaded_at' => now()->toISOString(),
                ]
            );

            $file->update(['order' => $order]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
