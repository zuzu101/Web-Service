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
        Schema::create('advantage_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    // Judul section "Kenapa Memilih Kami?"
            $table->string('background_image')->nullable(); // Background image (opsional untuk masa depan)
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advantage_sections');
    }
};
