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
            // Add is_active boolean column
            $table->boolean('is_active')->default(true)->after('description');
        });

        // Migrate data from status to is_active
        DB::table('steps')->update([
            'is_active' => DB::raw("CASE WHEN status = 'active' THEN 1 ELSE 0 END")
        ]);

        Schema::table('steps', function (Blueprint $table) {
            // Drop status column
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('steps', function (Blueprint $table) {
            // Add status enum column back
            $table->enum('status', ['active', 'inactive'])->default('active')->after('description');
        });

        // Migrate data from is_active to status
        DB::table('steps')->update([
            'status' => DB::raw("CASE WHEN is_active = 1 THEN 'active' ELSE 'inactive' END")
        ]);

        Schema::table('steps', function (Blueprint $table) {
            // Drop is_active column
            $table->dropColumn('is_active');
        });
    }
};
