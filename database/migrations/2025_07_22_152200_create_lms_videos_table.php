<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lms_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lms_meeting_id')->constrained()->onDelete('cascade');
            $table->string('title'); // e.g., "Video Bimbel 2"
            $table->string('youtube_url'); // Link video YouTube
            $table->string('duration')->nullable(); // e.g., "5 mins"
            $table->unsignedSmallInteger('order')->default(0); // Untuk urutan video
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lms_videos');
    }
};
