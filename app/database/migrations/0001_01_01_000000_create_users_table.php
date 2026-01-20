<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserStatusEnum;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->comment('UUID для API');
            $table->smallInteger('status')
                ->default(UserStatusEnum::Inactive->value)
                ->index()
                ->comment('Статус');
            $table->string('name', 100)->comment('Имя');
            $table->string('lastname', 100)->nullable()->comment('Фамилия');
            $table->string('email')->unique()->comment('E-mail');
            $table->timestamp('email_verified_at')->nullable()->comment('E-mail подтвержден');
            $table->string('phone', 20)->nullable()->unique()->comment('Телефон');
            $table->timestamp('phone_verified_at')->nullable()->comment('Телефон подтвержден');
            $table->string('password')->comment('Пароль');
            $table->text('two_factor_secret')->nullable()->comment('Секрет для 2FA');
            $table->text('two_factor_recovery_codes')->nullable()->comment('Коды восстановления для 2FA');
            $table->timestamp('two_factor_confirmed_at')->nullable()->comment('2FA подтверждена');
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable()->comment('Время последней авторизации');
            $table->timestamps();
            $table->softDeletes();

            $table->comment('Пользователи');
        });
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
        DB::statement('ALTER TABLE users ALTER COLUMN uuid SET DEFAULT uuid_generate_v4()');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
