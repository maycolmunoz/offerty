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
        Schema::create('business_types', function (Blueprint $table) {
            $table->foreignId('type_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->unique(['business_id', 'type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_types');
    }
};
