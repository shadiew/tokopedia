<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('checkout_url')->nullable()->after('status');
            $table->text('qr_string')->nullable()->after('checkout_url');
            $table->string('qr_url')->nullable()->after('qr_string');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['checkout_url', 'qr_string', 'qr_url']);
        });
    }
};
