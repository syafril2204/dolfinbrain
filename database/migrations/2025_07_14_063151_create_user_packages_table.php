<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->timestamp('expired_at')->nullable(); // Kapan paket ini berakhir
            $table->string('transaction_id')->nullable(); // ID dari payment gateway
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps(); // Ini akan berfungsi sebagai tanggal pembelian
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_packages');
    }
};
