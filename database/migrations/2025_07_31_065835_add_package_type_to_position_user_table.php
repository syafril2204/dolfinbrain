<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('position_user', function (Blueprint $table) {
            $table->string('package_type')->after('position_id');
        });
    }

    public function down(): void
    {
        Schema::table('position_user', function (Blueprint $table) {
            $table->dropColumn('package_type');
        });
    }
};
