<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('steps', function (Blueprint $table) {
            // Add new status column as enum
            $table->enum('status', ['active', 'inactive'])->default('active')->after('description');
        });

        // Migrate existing data: is_active true -> 'active', false -> 'inactive'
        DB::statement("UPDATE steps SET status = CASE WHEN is_active = 1 THEN 'active' ELSE 'inactive' END");

        Schema::table('steps', function (Blueprint $table) {
            // Drop old is_active column
            $table->dropColumn('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('steps', function (Blueprint $table) {
            // Add back is_active column
            $table->boolean('is_active')->default(true)->after('description');
        });

        // Migrate back data: 'active' -> true, 'inactive' -> false
        DB::statement("UPDATE steps SET is_active = CASE WHEN status = 'active' THEN 1 ELSE 0 END");

        Schema::table('steps', function (Blueprint $table) {
            // Drop status column
            $table->dropColumn('status');
        });
    }
};
