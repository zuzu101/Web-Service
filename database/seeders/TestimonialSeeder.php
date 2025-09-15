<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('testimonials')->delete();
        DB::table('testimonials')->insert([
            [
                'id' => 1,
                'name' => 'Sari Indrawati',
                'image' => 'testimonials/ICwmk1p5NxhY6lEDIYZQsG8Bsb8YRsGNfatyVOcu.png',
                'rating' => 5,
                'content' => null,
                'is_active' => 1,
                'order' => 1,
                'created_at' => '2025-09-14 22:53:12',
                'updated_at' => '2025-09-14 23:07:59',
            ],
            [
                'id' => 2,
                'name' => 'Rizky Pratama',
                'image' => 'testimonials/iCVZMez6gT20ZuDiUW65Djdgu5T6ow4nKaBBGJFc.png',
                'rating' => 5,
                'content' => null,
                'is_active' => 1,
                'order' => 2,
                'created_at' => '2025-09-14 22:54:01',
                'updated_at' => '2025-09-14 23:08:20',
            ],
            [
                'id' => 3,
                'name' => 'Athar Hilman',
                'image' => 'testimonials/s5sxA0ggo48PsLnBbiuL8fuFEAdOi4ZUdyCTG7bU.png',
                'rating' => 5,
                'content' => null,
                'is_active' => 1,
                'order' => 3,
                'created_at' => '2025-09-14 22:54:13',
                'updated_at' => '2025-09-14 23:08:40',
            ],
            [
                'id' => 4,
                'name' => 'rakan',
                'image' => 'testimonials/dp1p8SehlCDidyuHTLnrDn3vxzt290Exkro1S563.jpg',
                'rating' => 1,
                'content' => null,
                'is_active' => 0,
                'order' => 4,
                'created_at' => '2025-09-14 23:09:25',
                'updated_at' => '2025-09-14 23:18:35',
            ],
            [
                'id' => 5,
                'name' => 'qwerqwrqwe',
                'image' => 'testimonials/Hpbg8aozbwkF9lZltZFDMxwXtW86wjc1AHE61y7R.jpg',
                'rating' => 2,
                'content' => null,
                'is_active' => 0,
                'order' => 0,
                'created_at' => '2025-09-14 23:09:53',
                'updated_at' => '2025-09-14 23:18:50',
            ],
        ]);
        // Seed testimonial_sections persis seperti SQL
        if (DB::getSchemaBuilder()->hasTable('testimonial_sections')) {
            DB::table('testimonial_sections')->truncate();
            DB::table('testimonial_sections')->insert([
                [
                    'id' => 1,
                    'title' => 'Apa Kata Pelanggan Kami?',
                    'subtitle' => null,
                    'background_image' => null,
                    'is_active' => 1,
                    'created_at' => '2025-09-14 22:52:07',
                    'updated_at' => '2025-09-14 23:06:41',
                ]
            ]);
        }
    }
}
