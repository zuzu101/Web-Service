<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdvantageSectionSeeder extends Seeder
{
    public function run()
    {
        DB::table('advantage_sections')->truncate();
        DB::table('advantage_sections')->insert([
            [
                'id' => 1,
                'title' => 'Kenapa Memilih Kami?',
                'background_image' => null,
                'is_active' => 0,
                'created_at' => '2025-09-12 23:33:12',
                'updated_at' => '2025-09-13 00:12:19',
            ],
            [
                'id' => 2,
                'title' => 'Kenapa Memilih Kami?',
                'background_image' => null,
                'is_active' => 1,
                'created_at' => '2025-09-13 00:12:19',
                'updated_at' => '2025-09-13 00:13:23',
            ],
        ]);
    }
}
