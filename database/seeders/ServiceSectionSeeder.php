<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cms\ServiceSection;
use App\Models\Cms\Service;

class ServiceSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Service Section
        ServiceSection::create([
            'title' => 'Layanan Kami',
            'subtitle' => 'Solusi lengkap untuk semua kebutuhan service elektronik Anda',
            'is_active' => true
        ]);

        // Create Services
        $services = [
            [
                'title' => 'Service Laptop',
                'description' => 'Perbaikan laptop dengan diagnosa menyeluruh, penggantian komponen rusak, dan pembersihan sistem. Garansi hingga 30 hari.',
                'order_number' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Service Komputer',
                'description' => 'Layanan perbaikan PC desktop, upgrade hardware, instalasi software, dan optimasi sistem operasi untuk performa maksimal.',
                'order_number' => 2,
                'is_active' => true
            ],
            [
                'title' => 'Install Software',
                'description' => 'Instalasi sistem operasi, software aplikasi, driver, dan konfigurasi sistem sesuai kebutuhan bisnis atau personal.',
                'order_number' => 3,
                'is_active' => true
            ],
            [
                'title' => 'Recovery Data',
                'description' => 'Layanan pemulihan data yang hilang atau terhapus dari berbagai media penyimpanan dengan tingkat keberhasilan tinggi.',
                'order_number' => 4,
                'is_active' => true
            ],
            [
                'title' => 'Maintenance & Cleaning',
                'description' => 'Perawatan berkala dan pembersihan menyeluruh untuk menjaga performa perangkat tetap optimal dan awet.',
                'order_number' => 5,
                'is_active' => true
            ],
            [
                'title' => 'Konsultasi IT',
                'description' => 'Konsultasi profesional untuk kebutuhan IT bisnis, rekomendasi hardware, dan strategi digitalisasi perusahaan.',
                'order_number' => 6,
                'is_active' => true
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
