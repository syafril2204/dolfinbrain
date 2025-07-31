<?php
// File: database/migrations/xxxx_add_payment_details_to_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->text('checkout_url')->nullable()->after('status');
            $table->string('payment_code')->nullable()->after('checkout_url');
            $table->text('qr_url')->nullable()->after('payment_code');
            $table->datetime('expired_at')->nullable()->after('qr_url');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['checkout_url', 'payment_code', 'qr_url', 'expired_at']);
        });
    }
};
