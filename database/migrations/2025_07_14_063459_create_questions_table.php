<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_package_id')->constrained()->onDelete('cascade');
            $table->longText('question_text');
            $table->longText('explanation')->nullable(); // Penjelasan/pembahasan jawaban
            $table->unsignedTinyInteger('points')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
