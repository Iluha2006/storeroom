<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->comment('UUID для API');
            $table->string('hash', 64)->nullable()->index()->comment('SHA256 хеш файла');
            $table->string('disk', 20)->default('local')->index()->comment('Диск хранения');
            $table->string('path', 1024)->comment('Путь к файлу');
            $table->string('name', 255)->nullable()->comment('Пользовательское название');
            $table->string('filename', 255)->comment('Имя файла в системе');
            $table->string('original_name', 255)->comment('Оригинальное имя файла');
            $table->string('extension', 20)->nullable()->index()->comment('Расширение');
            $table->string('mime_type', 100)->nullable()->index()->comment('MIME тип');
            $table->unsignedBigInteger('size')->nullable()->comment('Размер, байт');
            $table->unsignedSmallInteger('width')->nullable()->comment('Ширина (для изображений)');
            $table->unsignedSmallInteger('height')->nullable()->comment('Высота (для изображений)');
            $table->unsignedInteger('order')->default(0)->comment('Порядок сортировки');
            $table->nullableMorphs('fileable', 'files_fileable_index');
            $table->string('collection', 50)->nullable()->index()->comment('Коллекция (files, documents, photos, images)');
            $table->jsonb('metadata')->nullable()->comment('Дополнительные метаданные');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hash', 'size'], 'files_duplicate_check');
            $table->index(['fileable_type', 'fileable_id', 'collection'], 'files_fileable_collection');
            $table->index(['fileable_type', 'fileable_id', 'collection', 'order'], 'files_fileable_ordered');
            $table->comment('Файлы');
        });
        DB::statement('ALTER TABLE files ALTER COLUMN uuid SET DEFAULT uuid_generate_v4()');
        DB::statement('CREATE INDEX files_metadata_gin ON files USING gin (metadata)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
