<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationTypeEnum;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->comment('UUID для API');
            $table->smallInteger('status')
                ->default(OrganizationStatusEnum::Inactive->value)
                ->index()
                ->comment('Статус');
            $table->string('type', 20)
                ->default(OrganizationTypeEnum::Individual->value)
                ->index()
                ->comment('Тип');
            $table->string('name')->comment('Название');
            $table->string('full_name', 500)->nullable()->comment('Полное наименование');
            $table->string('inn', 12)->nullable()->comment('ИНН');
            $table->string('kpp', 9)->nullable()->comment('КПП');
            $table->string('ogrn', 15)->nullable()->comment('ОГРН');
            $table->text('address')->nullable()->comment('Адрес');
            $table->string('phone', 20)->nullable()->comment('Телефон');
            $table->string('email')->nullable()->comment('E-mail');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['inn', 'ogrn']);
            $table->comment('Организации');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('organization_id')
                ->nullable()
                ->comment('ID организации')
                ->constrained('organizations')
                ->restrictOnDelete();
        });
        DB::statement('ALTER TABLE organizations ALTER COLUMN uuid SET DEFAULT uuid_generate_v4()');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
        Schema::dropIfExists('organizations');
    }
};
