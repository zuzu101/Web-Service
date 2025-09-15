<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promo_sections')->truncate();
        DB::table('promo_sections')->insert([
            [
                'id' => 1,
                'title' => 'Promo Spesial Bulan Ini',
                'subtitle' => 'Penawaran Terbatas Untuk Anda!',
                'background_image' => null,
                'is_active' => 1,
                'created_at' => '2025-09-14 21:17:44',
                'updated_at' => '2025-09-14 21:19:35',
            ]
        ]);
    }
}
