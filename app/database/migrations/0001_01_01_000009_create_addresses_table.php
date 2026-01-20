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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->comment('UUID для API');
            $table->foreignId('city_id')
                ->comment('ID города')
                ->constrained('cities')
                ->restrictOnDelete();
            $table->boolean('is_active')->default(false)->comment('Активен');
            $table->string('slug', 150)->nullable()->unique()->comment('Символьный код');
            $table->string('street', 150)->comment('Улица');
            $table->string('house', 10)->comment('Дом');
            $table->string('building', 10)->nullable()->comment('Строение');
            $table->string('frame', 10)->nullable()->comment('Корпус');
            $table->decimal('lat', 11, 8)->comment('Широта');
            $table->decimal('lon', 11, 8)->comment('Долгота');
            $table->text('how_to_get_there')->nullable()->comment('Как добраться');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['city_id', 'street', 'house', 'building', 'frame']);
            $table->unique(['lat', 'lon']);
            $table->index(['city_id', 'is_active']);
            $table->comment('Адреса');
        });
        DB::statement('ALTER TABLE addresses ALTER COLUMN uuid SET DEFAULT uuid_generate_v4()');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
