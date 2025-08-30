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
        Schema::create('device_repairs', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->text('reported_issue');
            $table->string('serial_number');
            $table->text('technician_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_repairs');
    }
};
