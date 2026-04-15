<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_cells', function (Blueprint $table) {
            $table->id();
            $table->foreignId("warehouse_cells_id")->constrained("warehouse_cells");
            $table->foreignId('warehouse_object_id')
            ->comment('ID объекта')
            ->constrained('warehouse_objects')
            ->restrictOnDelete();
            $table->decimal('price', 10, 2)->default(1)->comment('Цена, ₽');
            $table->string("name");
            $table->enum('status_payment',['success','сancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_cells');
    }
};
