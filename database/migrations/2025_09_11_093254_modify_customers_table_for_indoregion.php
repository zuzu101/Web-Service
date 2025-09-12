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
        Schema::table('customers', function (Blueprint $table) {
            // Add new address fields based on IndoRegion
            $table->string('province_id')->nullable()->after('address');
            $table->string('regency_id')->nullable()->after('province_id');
            $table->string('district_id')->nullable()->after('regency_id');
            $table->string('village_id')->nullable()->after('district_id');
            $table->text('street_address')->nullable()->after('village_id')->comment('Detail alamat seperti RT/RW, nama jalan, dll');
            
            // Add foreign key constraints
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('set null');
            $table->foreign('regency_id')->references('id')->on('regencies')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['province_id']);
            $table->dropForeign(['regency_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['village_id']);
            
            // Drop columns
            $table->dropColumn(['province_id', 'regency_id', 'district_id', 'village_id', 'street_address']);
        });
    }
};
