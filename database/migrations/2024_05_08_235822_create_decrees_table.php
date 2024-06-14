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
        Schema::create('decrees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('title');
            $table->string('number');
            $table->text('nomenclature')->nullable();
            $table->dateTime('start_from')->nullable()->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('end_to')->nullable();
            $table->string('document')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('council_categories')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('users_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('public')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decrees');
    }
};
