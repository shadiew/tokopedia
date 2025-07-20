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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('short_title')->nullable();
            $table->string('title')->nullable();
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->text('google_analytics')->nullable();
            $table->text('google_search')->nullable();
            $table->text('embed_code')->nullable();
            $table->string('tripay_merchant')->nullable();
            $table->string('tripay_apikey')->nullable();
            $table->string('tripay_privatekey')->nullable();
            $table->boolean('tripay_action')->default(0); // 1=Production, 0=Sandbox
            $table->string('whatsapp_appkey')->nullable();
            $table->string('whatsapp_authkey')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
}; 