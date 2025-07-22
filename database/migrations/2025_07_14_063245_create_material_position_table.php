<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_position', function (Blueprint $table) {
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->foreignId('position_id')->constrained()->onDelete('cascade');
            $table->primary(['material_id', 'position_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_position');
    }
};
