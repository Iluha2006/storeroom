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
        Schema::create('warehouse_objects', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->comment('UUID для API');
            $table->foreignId('address_id')
                ->comment('ID адреса')
                ->constrained('addresses')
                ->restrictOnDelete();
            $table->foreignId('organization_id')
                ->comment('ID организации')
                ->constrained('organizations')
                ->restrictOnDelete();
            $table->boolean('is_active')->default(false)->comment('Активен');
            $table->string('name', 150)->comment('Название');
            $table->string('slug', 150)->nullable()->unique()->comment('Символьный код');
            $table->text('description')->nullable()->comment('Описание');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['address_id', 'organization_id']);
            $table->index(['organization_id', 'is_active']);
            $table->index(['address_id', 'is_active']);
            $table->comment('Объекты');
        });
        DB::statement('ALTER TABLE warehouse_objects ALTER COLUMN uuid SET DEFAULT uuid_generate_v4()');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_objects');
    }
};
