<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdvantageSeeder extends Seeder
{
    public function run()
    {
        DB::table('advantages')->truncate();
        DB::table('advantages')->insert([
            [
                'id' => 1,
                'title' => 'Garansi Service',
                'description' => 'Garansi hingga 30 hari setelah service.',
                'icon' => 'advantages/1757745815_68c512974f1a3.png',
                'order_number' => 1,
                'is_active' => 1,
                'created_at' => '2025-09-12 23:23:09',
                'updated_at' => '2025-09-13 00:07:39',
            ],
            [
                'id' => 2,
                'title' => 'Teknisi Berpengalaman',
                'description' => 'Dikerjakan oleh teknisi profesional.',
                'icon' => 'advantages/1757745631_68c511df37d52.png',
                'order_number' => 2,
                'is_active' => 1,
                'created_at' => '2025-09-12 23:25:14',
                'updated_at' => '2025-09-12 23:40:31',
            ],
            [
                'id' => 3,
                'title' => 'Sparepart Original',
                'description' => 'Hanya menggunakan komponen original.',
                'icon' => 'advantages/1757744952_68c50f380a75b.png',
                'order_number' => 3,
                'is_active' => 1,
                'created_at' => '2025-09-12 23:29:12',
                'updated_at' => '2025-09-12 23:29:12',
            ],
            [
                'id' => 4,
                'title' => 'Gratis Cek & Konsultasi',
                'description' => 'Konsultasi bebas biaya, langsung WA.',
                'icon' => 'advantages/1757744984_68c50f58eaab6.png',
                'order_number' => 4,
                'is_active' => 1,
                'created_at' => '2025-09-12 23:29:44',
                'updated_at' => '2025-09-12 23:29:44',
            ],
            [
                'id' => 5,
                'title' => 'test',
                'description' => 'test',
                'icon' => 'advantages/1757746540_68c5156c9e6ea.jpg',
                'order_number' => 5,
                'is_active' => 0,
                'created_at' => '2025-09-12 23:55:40',
                'updated_at' => '2025-09-13 00:07:43',
            ],
        ]);
    }
}
