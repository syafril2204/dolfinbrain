<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lms_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lms_meeting_id')->constrained()->onDelete('cascade');
            $table->string('title'); // e.g., "Recap Meet", "Audio Ibu Rina"
            $table->string('file_path');
            $table->unsignedInteger('file_size')->nullable();
            $table->string('file_type', 20)->nullable(); // e.g., pdf, mp3
            $table->enum('type', ['recap_file', 'audio_recording', 'other']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lms_resources');
    }
};
