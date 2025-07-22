<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Paket 1 P3T"
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('duration_in_minutes'); // Durasi pengerjaan dalam menit
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_packages');
    }
};
