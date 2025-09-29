<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('videos')->delete();
        DB::table('videos')->insert([
            [
                'id' => 1,
                'title' => 'test',
                'description' => 'test',
                'video_url' => 'https://web.whatsapp.com/',
                'video_id' => null,
                'thumbnail_url' => null,
                'is_active' => 0,
                'activated_at' => '2025-09-14 20:01:57',
                'created_at' => '2025-09-14 20:01:57',
                'updated_at' => '2025-09-14 20:11:08',
            ],
            [
                'id' => 2,
                'title' => 'Proses Service Laptop Gaming',
                'description' => 'Teknisi kami menunjukkan proses pembersihan dan perbaikan laptop gaming dengan detail',
                'video_url' => 'https://www.youtube.com/watch?v=OBBMF_9oD5g',
                'video_id' => 'OBBMF_9oD5g',
                'thumbnail_url' => 'https://img.youtube.com/vi/OBBMF_9oD5g/maxresdefault.jpg',
                'is_active' => 1,
                'activated_at' => '2025-09-14 20:05:46',
                'created_at' => '2025-09-14 20:05:46',
                'updated_at' => '2025-09-14 20:05:46',
            ],
            [
                'id' => 3,
                'title' => 'Tutorial Upgrade RAM SSD',
                'description' => 'Proses upgrade komponen laptop untuk meningkatkan performa secara signifikan',
                'video_url' => 'https://www.youtube.com/watch?v=3edtMfPl_kM',
                'video_id' => '3edtMfPl_kM',
                'thumbnail_url' => 'https://img.youtube.com/vi/3edtMfPl_kM/maxresdefault.jpg',
                'is_active' => 1,
                'activated_at' => '2025-09-14 20:06:51',
                'created_at' => '2025-09-14 20:06:51',
                'updated_at' => '2025-09-14 20:18:16',
            ],
            [
                'id' => 4,
                'title' => 'Pembersihan Laptop Menyeluruh',
                'description' => 'Tutorial pembersihan laptop dari debu dan kotoran untuk menjaga performa optimal',
                'video_url' => 'https://www.youtube.com/watch?v=4KqtyO_5qis',
                'video_id' => '4KqtyO_5qis',
                'thumbnail_url' => 'https://img.youtube.com/vi/4KqtyO_5qis/maxresdefault.jpg',
                'is_active' => 0,
                'activated_at' => '2025-09-14 20:09:06',
                'created_at' => '2025-09-14 20:09:06',
                'updated_at' => '2025-09-14 20:18:40',
            ],
        ]);
    }
}
