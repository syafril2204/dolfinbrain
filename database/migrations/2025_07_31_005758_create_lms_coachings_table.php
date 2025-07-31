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
        Schema::create('lms_coachings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lms_space_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Topik coaching, cth: "Strategi Menjawab Soal TWK"
            $table->string('trainer_name')->nullable();
            $table->string('meeting_url')->nullable(); // Link Zoom/GMeet
            $table->timestamp('start_at')->nullable(); // Jadwal mulai
            $table->timestamp('end_at')->nullable(); // Jadwal selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_coachings');
    }
};
