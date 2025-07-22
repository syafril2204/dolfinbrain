<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('position_quiz_package', function (Blueprint $table) {
            $table->foreignId('position_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_package_id')->constrained()->onDelete('cascade');
            $table->primary(['position_id', 'quiz_package_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('position_quiz_package');
    }
};
