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
        Schema::create('councils', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('website')->nullable();
            $table->text('address_street')->nullable();
            $table->text('address_building')->nullable();
            $table->foreignId('indonesian_region_village_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('indonesian_region_district_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('indonesian_region_regency_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('indonesian_region_province_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('councils');
    }
};
