<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cms\HeroSection;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data persis seperti SQL
        HeroSection::truncate();
        HeroSection::insert([
            [
                'id' => 1,
                'title' => 'Cepat, Jujur, dan Bergaransi',
                'title2' => null,
                'description' => 'Kami siap membantu mengatasi berbagai masalah pada perangkat Anda, mulai dari laptop standar hingga laptop gaming, dengan layanan profesional dan terpercaya. Percayakan kepada ahlinya!',
                'image1' => 'cms/hero/hero_image1_1726230123.jpg',
                'is_active' => 0,
                'created_at' => '2025-09-12 21:25:21',
                'updated_at' => '2025-09-12 21:26:08',
            ],
            [
                'id' => 2,
                'title' => 'Service Cepat, Hasil Berkualitas, Harga Terjangkau',
                'title2' => null,
                'description' => 'Tidak perlu khawatir dengan kerusakan laptop atau komputer Anda. Tim ahli kami siap memberikan solusi terbaik dengan waktu pengerjaan yang cepat dan hasil yang memuaskan.',
                'image1' => null,
                'is_active' => 0,
                'created_at' => '2025-09-12 20:29:55',
                'updated_at' => '2025-09-12 21:25:21',
            ],
            [
                'id' => 3,
                'title' => 'Layanan On-Site Available - Kami Datang ke Tempat Anda',
                'title2' => null,
                'description' => 'Kesibukan tinggi? Tidak masalah! Kami menyediakan layanan panggilan untuk service di lokasi Anda. Hubungi kami untuk jadwal kunjungan teknisi profesional kami.',
                'image1' => null,
                'is_active' => 0,
                'created_at' => '2025-09-12 20:29:55',
                'updated_at' => '2025-09-12 21:25:21',
            ],
            [
                'id' => 4,
                'title' => 'Solusi Terpercaya untuk Semua Kebutuhan Service Laptop Anda',
                'title2' => null,
                'description' => 'Dengan teknisi berpengalaman dan peralatan modern, kami siap memberikan pelayanan terbaik untuk laptop, komputer, dan perangkat elektronik Anda. Dapatkan diagnosa gratis dan garansi service hingga 30 hari.',
                'image1' => null,
                'is_active' => 0,
                'created_at' => '2025-09-12 20:40:22',
                'updated_at' => '2025-09-12 21:25:21',
            ],
            [
                'id' => 5,
                'title' => 'Service Cepat, Hasil Berkualitas, Harga Terjangkau',
                'title2' => null,
                'description' => 'Tidak perlu khawatir dengan kerusakan laptop atau komputer Anda. Tim ahli kami siap memberikan solusi terbaik dengan waktu pengerjaan yang cepat dan hasil yang memuaskan.',
                'image1' => null,
                'is_active' => 0,
                'created_at' => '2025-09-12 20:40:22',
                'updated_at' => '2025-09-12 21:25:21',
            ],
            [
                'id' => 6,
                'title' => 'Layanan On-Site Available - Kami Datang ke Tempat Anda',
                'title2' => null,
                'description' => 'Kesibukan tinggi? Tidak masalah! Kami menyediakan layanan panggilan untuk service di lokasi Anda. Hubungi kami untuk jadwal kunjungan teknisi profesional kami.',
                'image1' => null,
                'is_active' => 0,
                'created_at' => '2025-09-12 20:40:22',
                'updated_at' => '2025-09-12 21:41:09',
            ],
            [
                'id' => 7,
                'title' => '1',
                'title2' => '2',
                'description' => 'test',
                'image1' => 'cms/hero/hero_image1_1757736439.jpg',
                'is_active' => 0,
                'created_at' => '2025-09-12 21:07:19',
                'updated_at' => '2025-09-15 01:02:28',
            ],
            [
                'id' => 8,
                'title' => 'Service Laptop',
                'title2' => 'Cepat, Jujur, dan Bergaransi',
                'description' => 'Kami siap membantu mengatasi berbagai masalah pada perangkat Anda, mulai dari laptop standar hingga laptop gaming, dengan layanan profesional dan terpercaya. Percayakan kepada ahlinya!',
                'image1' => 'cms/hero/hero_image1_1757736761.png',
                'is_active' => 1,
                'created_at' => '2025-09-12 21:12:41',
                'updated_at' => '2025-09-15 01:02:28',
            ],
        ]);
    }
}
