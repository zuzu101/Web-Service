<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cms\StepSection;

class StepSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to ensure only one record
        StepSection::truncate();

        // Create the single step section record
        StepSection::create([
            'title' => '3 Langkah Mudah Layanan Kami',
            'subtitle' => 'Ikuti alur sederhana kami untuk mendapatkan layanan perbaikan yang cepat dan efisien.',
            'background_image' => 'BGalur.png',
            'is_active' => true,
            'order' => 0,
        ]);
    }
}