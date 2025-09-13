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
        // Create step section
        $stepSection = StepSection::create([
            'title' => '3 Langkah Mudah Layanan Kami',
            'subtitle' => 'Proses mudah dan cepat untuk mendapatkan layanan terbaik dari kami dengan sistem yang telah terintegrasi',
            'is_active' => true,
            'order' => 1,
        ]);

        // Create 3 steps
        $steps = [
            [
                'icon' => 'consultation.png', // placeholder icon name
                'title' => 'Konsultasi Gratis',
                'description' => 'Konsultasi gratis dengan teknisi ahli kami untuk mengetahui masalah perangkat elektronik Anda. Kami akan memberikan analisa mendalam dan solusi terbaik.',
                'is_active' => true,
                'order' => 1,
                'activated_at' => now(),
            ],
            [
                'icon' => 'repair.png', // placeholder icon name
                'title' => 'Proses Perbaikan',
                'description' => 'Tim teknisi berpengalaman kami akan melakukan perbaikan dengan menggunakan spare part original dan teknologi terkini untuk hasil yang maksimal.',
                'is_active' => true,
                'order' => 2,
                'activated_at' => now(),
            ],
            [
                'icon' => 'delivery.png', // placeholder icon name
                'title' => 'Selesai & Garansi',
                'description' => 'Perangkat Anda akan dikembalikan dalam kondisi prima dengan garansi resmi. Kami juga menyediakan layanan antar jemput untuk kemudahan Anda.',
                'is_active' => true,
                'order' => 3,
                'activated_at' => now(),
            ],
        ];

        foreach ($steps as $step) {
            Step::create($step);
        }

        $this->command->info('Step section and steps seeded successfully!');
    }
}
