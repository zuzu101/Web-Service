<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CmsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('cms_sections')->truncate();
        \DB::table('cms_sections')->insert([
            [
                'id' => 1,
                'name' => 'hero',
                'title' => 'Hero Section',
                'description' => 'Section utama pada halaman landing page',
                'is_active' => 1,
                'sort_order' => 1,
                'settings' => null,
                'created_at' => '2025-09-12 20:06:59',
                'updated_at' => '2025-09-12 20:06:59',
            ],
            [
                'id' => 2,
                'name' => 'about',
                'title' => 'Tentang Kami',
                'description' => 'Section tentang informasi perusahaan',
                'is_active' => 1,
                'sort_order' => 2,
                'settings' => null,
                'created_at' => '2025-09-12 20:06:59',
                'updated_at' => '2025-09-12 20:06:59',
            ],
            [
                'id' => 3,
                'name' => 'services',
                'title' => 'Layanan',
                'description' => 'Section layanan yang ditawarkan',
                'is_active' => 1,
                'sort_order' => 3,
                'settings' => null,
                'created_at' => '2025-09-12 20:06:59',
                'updated_at' => '2025-09-12 20:06:59',
            ],
            [
                'id' => 4,
                'name' => 'features',
                'title' => 'Keunggulan',
                'description' => 'Section keunggulan atau fitur utama',
                'is_active' => 1,
                'sort_order' => 4,
                'settings' => null,
                'created_at' => '2025-09-12 20:06:59',
                'updated_at' => '2025-09-12 20:06:59',
            ],
            [
                'id' => 5,
                'name' => 'testimonials',
                'title' => 'Testimoni',
                'description' => 'Section testimoni pelanggan',
                'is_active' => 1,
                'sort_order' => 5,
                'settings' => null,
                'created_at' => '2025-09-12 20:06:59',
                'updated_at' => '2025-09-12 20:06:59',
            ],
            [
                'id' => 6,
                'name' => 'contact',
                'title' => 'Kontak',
                'description' => 'Section informasi kontak',
                'is_active' => 1,
                'sort_order' => 6,
                'settings' => null,
                'created_at' => '2025-09-12 20:06:59',
                'updated_at' => '2025-09-12 20:06:59',
            ],
        ]);
    }
}
