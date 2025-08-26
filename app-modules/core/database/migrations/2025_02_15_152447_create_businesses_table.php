<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Enums\StatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name', 100)->unique();
            $table->text('description');
            $table->string('image');
            $table->string('phone', 100);
            $table->string('email', 100)->unique();
            $table->enum('status', [
                StatusEnum::APPROVED->value,
                StatusEnum::REJECTED->value,
                StatusEnum::PENDING->value,
            ])
                ->default(StatusEnum::PENDING->value);
            $table->string('status_description')->nullable();
            $table->string('address');
            $table->double('longitude');
            $table->double('latitude');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
