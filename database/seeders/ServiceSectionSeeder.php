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
        // Data persis seperti SQL
        Service::truncate();
        Service::insert([
            [
                'id' => 7,
                'title' => 'Test',
                'description' => 'Ganti LCD, keyboard, upgrade RAM/SSD, dll.',
                'image' => 'services/1757750523_68c524fb55fe6.png',
                'order_number' => 1,
                'is_active' => 1,
                'created_at' => '2025-09-13 01:02:03',
                'updated_at' => '2025-09-14 20:41:15',
            ],
            [
                'id' => 8,
                'title' => 'Service Software',
                'description' => 'Install ulang, recovery data, pasang antivirus.',
                'image' => 'services/1757750649_68c5257922a11.png',
                'order_number' => 2,
                'is_active' => 1,
                'created_at' => '2025-09-13 01:04:09',
                'updated_at' => '2025-09-13 01:04:09',
            ],
            [
                'id' => 9,
                'title' => 'Maintenance & Cleaning',
                'description' => 'Bersihkan laptop dari debu, thermal paste, dll.',
                'image' => 'services/1757750711_68c525b7c6825.png',
                'order_number' => 3,
                'is_active' => 1,
                'created_at' => '2025-09-13 01:05:11',
                'updated_at' => '2025-09-13 01:05:11',
            ],
            [
                'id' => 10,
                'title' => 'Service Printer & PC',
                'description' => 'Untuk printer rumah/kantor, juga PC rakitan.',
                'image' => 'services/1757750744_68c525d8530f4.png',
                'order_number' => 4,
                'is_active' => 1,
                'created_at' => '2025-09-13 01:05:44',
                'updated_at' => '2025-09-13 01:05:44',
            ],
        ]);
    }
}
