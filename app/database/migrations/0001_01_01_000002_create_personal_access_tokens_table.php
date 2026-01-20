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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->morphs('tokenable');
            $table->text('name')->comment('Название');
            $table->string('token', 64)->unique()->comment('Токен');
            $table->text('abilities')->nullable()->comment('Способности');
            $table->timestamp('last_used_at')->nullable()->comment('Когда использовался');
            $table->timestamp('expires_at')->nullable()->index()->comment('Когда истекает');
            $table->timestamp('created_at')->nullable()->comment('Создано');
            $table->timestamp('updated_at')->nullable()->comment('Изменено');
            $table->comment('Персональные токены доступа');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
