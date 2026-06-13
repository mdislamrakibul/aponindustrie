<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_orders', function (Blueprint $table) {
            $table->string('payer_number', 50)->nullable()->after('transaction_id');
            $table->string('payment_screenshot')->nullable()->after('payer_number');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_orders', function (Blueprint $table) {
            $table->dropColumn(['payer_number', 'payment_screenshot']);
        });
    }
};
