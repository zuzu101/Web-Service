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
        HeroSection::create([
            'title' => 'Solusi Terpercaya untuk Semua Kebutuhan Service Laptop Anda',
            'description' => 'Dengan teknisi berpengalaman dan peralatan modern, kami siap memberikan pelayanan terbaik untuk laptop, komputer, dan perangkat elektronik Anda. Dapatkan diagnosa gratis dan garansi service hingga 30 hari.',
            'is_active' => true
        ]);

        HeroSection::create([
            'title' => 'Service Cepat, Hasil Berkualitas, Harga Terjangkau',
            'description' => 'Tidak perlu khawatir dengan kerusakan laptop atau komputer Anda. Tim ahli kami siap memberikan solusi terbaik dengan waktu pengerjaan yang cepat dan hasil yang memuaskan.',
            'is_active' => true
        ]);

        HeroSection::create([
            'title' => 'Layanan On-Site Available - Kami Datang ke Tempat Anda',
            'description' => 'Kesibukan tinggi? Tidak masalah! Kami menyediakan layanan panggilan untuk service di lokasi Anda. Hubungi kami untuk jadwal kunjungan teknisi profesional kami.',
            'is_active' => false
        ]);
    }
}
