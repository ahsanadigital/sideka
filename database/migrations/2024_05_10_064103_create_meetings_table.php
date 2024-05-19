<?php

use App\Enums\MeetingTypeEnum;
use App\Models\Meeting;
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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title', 156);
            $table->enum('type', Meeting::getMeetingTypeEnum()->toArray())->default(MeetingTypeEnum::OTHER->value);
            $table->unsignedInteger('participant')->default(0);
            $table->string('description', 255)->nullable();
            $table->string('result', 255)->nullable();
			$table->date('date')->useCurrentOnUpdate();
            $table->foreignId('users_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
