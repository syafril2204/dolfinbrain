<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->unsignedInteger('price_mandiri')->default(0)->after('slug');
            $table->unsignedInteger('price_bimbingan')->default(0)->after('price_mandiri');
        });
    }

    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->unsignedInteger('price')->default(0);
            $table->dropColumn(['price_mandiri', 'price_bimbingan']);
        });
    }
};
