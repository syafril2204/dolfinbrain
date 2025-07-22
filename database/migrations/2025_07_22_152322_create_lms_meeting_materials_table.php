<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lms_meeting_material', function (Blueprint $table) {
            $table->foreignId('lms_meeting_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->primary(['lms_meeting_id', 'material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lms_meeting_material');
    }
};
