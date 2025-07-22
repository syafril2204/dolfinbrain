<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_package_id')->constrained()->onDelete('cascade');
            $table->decimal('score', 5, 2)->nullable(); // Total skor, e.g., 85.50
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->timestamp('finished_at')->nullable();
            $table->timestamps(); // created_at akan jadi started_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
