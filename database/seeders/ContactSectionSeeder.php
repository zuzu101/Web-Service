<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contact_sections')->delete();
        DB::table('contact_sections')->insert([
            [
                'id' => 1,
                'maps_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.859986822602!2d107.64005986842982!3d-6.907340752305002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dda5a21cc6bb%3A0xb7248e14780c4720!2sCV%20Lingkar%20Rasio%20Teknologi!5e0!3m2!1sid!2sid!4v1757927242198!5m2!1sid!2sid',
                'is_active' => 1,
                'created_at' => '2025-09-15 01:42:50',
                'updated_at' => '2025-09-15 02:08:11',
            ],
        ]);
    }
}
