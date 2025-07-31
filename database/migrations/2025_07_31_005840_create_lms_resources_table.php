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
        Schema::create('lms_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lms_space_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('file_path');
            $table->unsignedInteger('file_size')->nullable();
            $table->string('file_type', 20)->nullable();
            $table->enum('type', ['recap_file', 'audio_recording', 'other']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_resources');
    }
};
