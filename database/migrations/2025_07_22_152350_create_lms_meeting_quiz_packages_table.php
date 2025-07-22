<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * up
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('lms_meeting_quiz_package', function (Blueprint $table) {
            $table->foreignId('lms_meeting_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_package_id')->constrained()->onDelete('cascade');
            $table->primary(['lms_meeting_id', 'quiz_package_id']);
        });
    }

    /**
     * down
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_meeting_quiz_package');
    }
};
