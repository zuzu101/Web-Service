<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cms\StepSection;
use App\Models\Cms\Step;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data persis seperti SQL
        StepSection::truncate();
        Step::truncate();
        StepSection::insert([
            [
                'id' => 1,
                'title' => '3 Langkah Mudah Layanan Kami',
                'subtitle' => 'Ikuti alur sederhana kami untuk mendapatkan layanan perbaikan yang cepat dan efisien.',
                'background_image' => null,
                'is_active' => 1,
                'order' => 0,
                'created_at' => '2025-09-13 02:19:08',
                'updated_at' => '2025-09-13 02:19:08',
            ],
        ]);
        Step::insert([
            [
                'id' => 2,
                'icon' => '1757755477_pengerjaan.png',
                'title' => 'Pengerjaan Teknisi',
                'description' => 'Teknisi ahli kami akan segera menganalisa dan memperbaiki masalahnya.',
                'is_active' => 1,
                'order' => 2,
                'activated_at' => '2025-09-13 01:26:42',
                'created_at' => '2025-09-13 01:26:42',
                'updated_at' => '2025-09-13 02:24:37',
            ],
            [
                'id' => 5,
                'icon' => '1757755398_konsultasi.png',
                'title' => 'Konsultasi Kerusakan',
                'description' => 'Hubungi kami dan sampaikan masalah yang terjadi pada perangkat Anda',
                'is_active' => 1,
                'order' => 1,
                'activated_at' => '2025-09-13 02:01:08',
                'created_at' => '2025-09-13 02:01:08',
                'updated_at' => '2025-09-13 02:59:04',
            ],
            [
                'id' => 6,
                'icon' => '1757755553_selesai.png',
                'title' => 'Unit Siap Diambil',
                'description' => 'Kami akan menghubungi Anda jika perangkat sudah selesai diperbaiki.',
                'is_active' => 1,
                'order' => 3,
                'activated_at' => '2025-09-13 02:01:16',
                'created_at' => '2025-09-13 02:01:16',
                'updated_at' => '2025-09-13 02:25:53',
            ],
        ]);
    }
}
