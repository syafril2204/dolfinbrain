<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lms_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Pertemuan 1: Bimbingan Lanjutan"
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamp('scheduled_at')->nullable(); // Jadwal live meeting
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lms_meetings');
    }
};
