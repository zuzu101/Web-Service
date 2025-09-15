<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\CtaSection;

class CtaSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('cta_sections')->truncate();
        \DB::table('cta_sections')->insert([
            [
                'id' => 3,
                'title' => 'Jangan tunggu kerusakan makin parah, segera hubungi kami sekarang!',
                'background_image' => null,
                'is_active' => 1,
                'created_at' => '2025-09-15 00:38:35',
                'updated_at' => '2025-09-15 01:17:17',
            ],
            [
                'id' => 4,
                'title' => 'teat',
                'background_image' => 'cta-backgrounds/MeGo2UsjUthrUVgrSMZVd2WjFaKz6ZjComFoZaE6.jpg',
                'is_active' => 0,
                'created_at' => '2025-09-15 01:03:24',
                'updated_at' => '2025-09-15 01:17:17',
            ],
        ]);
    }
}
