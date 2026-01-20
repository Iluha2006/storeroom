<?php

namespace App\Traits;

use Str;
use Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\File;
use App\Enums\FileCollectionEnum;
use App\Enums\FilesystemDiskEnum;
use Illuminate\Database\Eloquent\Relations\MorphOne;


trait HasFiles
{
    /**
     * Все файлы модели через polymorphic связь
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')
            ->orderBy('order')
            ->orderBy('created_at');
    }

    /**
     * Файлы конкретной коллекции
     */
    public function getFiles(FileCollectionEnum $collection): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')
            ->where('collection', $collection->value)
            ->orderBy('order')
            ->orderBy('created_at');
    }

    /**
     * Первый файл из коллекции
     */
    public function getFirstFile(FileCollectionEnum $collection): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('collection', $collection->value)
            ->orderBy('order')
            ->orderBy('created_at');
    }

    /**
     * Добавить файл
     */
    public function addFile(
        UploadedFile        $uploadedFile,
        FilesystemDiskEnum  $disk = FilesystemDiskEnum::Public,
        ?FileCollectionEnum $collection = null,
        array               $metadata = []
    ): File
    {
        $hash = hash_file('sha256', $uploadedFile->path());

        // Проверка на дубль (опционально - можно отключить)
        $existing = File::where('hash', $hash)
            ->where('size', $uploadedFile->getSize())
            ->first();

        if ($existing) {
            // Создаем новую связь с существующим файлом
            // Это позволяет одному файлу принадлежать нескольким моделям
            return $this->files()->create([
                'hash' => $existing->hash,
                'disk' => $existing->disk,
                'path' => $existing->path,
                'filename' => $existing->filename,
                'original_name' => $uploadedFile->getClientOriginalName(),
                'extension' => $existing->extension,
                'mime_type' => $existing->mime_type,
                'size' => $existing->size,
                'width' => $existing->width,
                'height' => $existing->height,
                'collection' => $collection?->value,
                'metadata' => $metadata,
            ]);
        }

        // Генерируем уникальное имя файла
        $filename = Str::uuid() . '.' . $uploadedFile->getClientOriginalExtension();

        // Сохраняем файл
        $path = $uploadedFile->storeAs(
            $collection?->value ?? 'files',
            $filename,
            $disk->value
        );

        // Подготавливаем данные для создания записи
        $fileData = [
            'hash' => $hash,
            'disk' => $disk->value,
            'path' => $path,
            'filename' => $filename,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'extension' => $uploadedFile->getClientOriginalExtension(),
            'mime_type' => $uploadedFile->getMimeType(),
            'size' => $uploadedFile->getSize(),
            'collection' => $collection?->value,
            'metadata' => $metadata,
        ];

        // Если это изображение - добавляем размеры
        if (str_starts_with($uploadedFile->getMimeType(), 'image/')) {
            $image = getimagesize($uploadedFile->path());
            if ($image) {
                $fileData['width'] = $image[0];
                $fileData['height'] = $image[1];
            }
        }

        // Создаем запись файла с привязкой к текущей модели
        return $this->files()->create($fileData);
    }

    /**
     * Удалить файлы коллекции
     */
    public function clearFiles(?FileCollectionEnum $collection = null): void
    {
        $query = $this->files();

        if ($collection instanceof FileCollectionEnum) {
            $query->where('collection', $collection->value);
        }

        $query->each(function ($file) {
            // Проверяем, используется ли файл другими моделями
            $usageCount = File::where('hash', $file->hash)
                ->where('size', $file->size)
                ->count();

            // Удаляем физический файл, только если он не используется
            if ($usageCount <= 1) {
                Storage::disk($file->disk)->delete($file->path);
            }

            // Удаляем запись из БД
            $file->delete();
        });
    }

    /**
     * Удалить все файлы при удалении модели
     */
    protected static function bootHasFiles(): void
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && $model->isForceDeleting()) {
                // При force delete удаляем все файлы
                $model->clearFiles();
            }
        });
    }
}
