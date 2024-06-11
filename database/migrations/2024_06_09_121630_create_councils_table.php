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
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address_street')->nullable();
            $table->text('address_building')->nullable();
            $table->foreignId('address_village')->nullable()->constrained('indonesian_region_villages')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('address_district')->nullable()->constrained('indonesian_region_districts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('address_regency')->nullable()->constrained('indonesian_region_regencies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('address_province')->nullable()->constrained('indonesian_region_provinces')->cascadeOnDelete()->cascadeOnUpdate();
            $table->char('address_postcode', 6)->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_phone')->nullable();
            $table->string('pic_email')->nullable();
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
