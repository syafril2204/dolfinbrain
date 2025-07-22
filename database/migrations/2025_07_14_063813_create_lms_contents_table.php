<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lms_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lms_meeting_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['materi', 'coaching', 'rekaman', 'kuis', 'file', 'audio']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('content_url')->nullable();
            $table->foreignId('quiz_package_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lms_contents');
    }
};
