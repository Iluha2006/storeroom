<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\WarehouseCellStatusEnum;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse_cells', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->comment('UUID для API');
            $table->foreignId('warehouse_object_id')
                ->comment('ID объекта')
                ->constrained('warehouse_objects')
                ->restrictOnDelete();
            $table->smallInteger('status')
                ->default(WarehouseCellStatusEnum::Unavailable->value)
                ->index()
                ->comment('Статус');
            $table->string('slug', 150)->nullable()->unique()->comment('Символьный код');
            $table->smallInteger('floor')->nullable()->comment('Этаж');
            $table->string('row', 5)->nullable()->comment('Ряд');
            $table->string('section', 5)->nullable()->comment('Секция');
            $table->string('level', 5)->nullable()->comment('Уровень');
            $table->string('number', 20)->comment('Номер ячейки');
            $table->integer('length')->index()->comment('Длинна, см');
            $table->integer('height')->index()->comment('Высота, см');
            $table->integer('width')->index()->comment('Ширина, см');
            $table->integer('volume')
                ->storedAs('length * height * width')
                ->index()
                ->comment('Объем, см³');
            $table->decimal('price', 10, 2)->default(3)->comment('Цена, ₽');
            $table->text('how_to_get_there')->nullable()->comment('Как пройти');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['warehouse_object_id', 'number']);
            $table->index(['warehouse_object_id', 'status']);
            $table->comment('Ячейки');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_cells');
    }
};
