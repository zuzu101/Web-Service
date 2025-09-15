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
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            $table->string('icon', 500)->nullable(); // Path file gambar/icon
            $table->string('title'); // WhatsApp, Email, Lokasi, dll
            $table->text('content'); // nomor/email/alamat
            $table->string('link')->nullable(); // untuk WhatsApp link, email mailto, dll
            $table->integer('order')->default(0); // urutan tampil
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};
