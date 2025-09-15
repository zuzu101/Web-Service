<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\ContactInfo;
use App\Models\ContactSection;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('contact_infos')->truncate();
        \DB::table('contact_infos')->insert([
            [
                'id' => 1,
                'icon' => 'contact-info/1757932984_68c7edb8af153.png',
                'title' => 'WhatsApp',
                'content' => '+62 812-3456-7890',
                'link' => 'https://wa.me/6281234567890',
                'order' => 1,
                'is_active' => 1,
                'created_at' => '2025-09-15 01:42:50',
                'updated_at' => '2025-09-15 03:43:04',
            ],
            [
                'id' => 2,
                'icon' => 'contact-info/1757933273_68c7eed9f14a7.png',
                'title' => 'Email',
                'content' => 'support@servicelaptop.com',
                'link' => null,
                'order' => 2,
                'is_active' => 1,
                'created_at' => '2025-09-15 01:42:50',
                'updated_at' => '2025-09-15 03:47:53',
            ],
            [
                'id' => 3,
                'icon' => 'contact-info/1757933286_68c7eee6df00a.png',
                'title' => 'Lokasi',
                'content' => 'Jalan traktor 123 dekat cicukang belakang kantor PU ujung berung, Kec. Arcamanik, Kota Bandung, Jawa Barat 42094',
                'link' => 'https://maps.google.com/maps?q=CV+Lingkar+Rasio+Teknologi',
                'order' => 3,
                'is_active' => 1,
                'created_at' => '2025-09-15 01:42:50',
                'updated_at' => '2025-09-15 03:48:06',
            ],
        ]);

        \DB::table('contact_sections')->truncate();
        \DB::table('contact_sections')->insert([
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
