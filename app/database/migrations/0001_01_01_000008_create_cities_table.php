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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->comment('UUID для API');
            $table->boolean('is_active')->default(false)->comment('Активен');
            $table->string('name', 150)->unique()->comment('Название');
            $table->string('slug', 150)->nullable()->unique()->comment('Символьный код');
            $table->timestamps();
            $table->softDeletes();

            $table->comment('Города');
        });
        DB::statement('ALTER TABLE cities ALTER COLUMN uuid SET DEFAULT uuid_generate_v4()');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
