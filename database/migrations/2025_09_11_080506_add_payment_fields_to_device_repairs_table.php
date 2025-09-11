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
        Schema::table('device_repairs', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'transfer'])->nullable()->after('price');
            $table->string('transfer_proof')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_repairs', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'transfer_proof']);
        });
    }
};
