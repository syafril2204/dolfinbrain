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
        Schema::create('lms_spaces', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul utama LMS Space
            $table->string('slug')->unique();
            $table->text('description')->nullable(); // Deskripsi umum
            $table->string('image_path')->nullable(); // Foto sampul
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_spaces');
    }
};
