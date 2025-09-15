<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideoSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('video_sections')->delete();
        DB::table('video_sections')->insert([
            [
                'id' => 1,
                'title' => 'Video Profil Service Laptop',
                'subtitle' => 'Kenali layanan dan keunggulan kami melalui video berikut.',
                'background_image' => 'Frame 32.png',
                'is_active' => 1,
                'created_at' => '2025-09-15 01:00:00',
                'updated_at' => '2025-09-15 01:00:00',
            ],
            // Tambahkan data lain sesuai SQL Anda
        ]);
    }
}
