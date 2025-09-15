<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cms\Promo;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promo::truncate();
        Promo::insert([
            [
                'id' => 1,
                'title' => 'Hemat hingga 20% untuk Maintenance Rutin',
                'description' => 'Rawat laptop Anda secara berkala dan dapatkan diskon menarik untuk setiap kunjungan ke-2 dan seterusnya.',
                'image' => 'cms/promo/promo_1757910342.png',
                'discount_text' => null,
                'features' => '["Pembersihan menyeluruh sistem","Update software terbaru","Optimasi performa laptop","Garansi layanan 30 hari"]',
                'button_text' => 'Jadwalkan Sekarang',
                'whatsapp_template' => 'Halo, saya tertarik dengan promo maintenance rutin. Mohon info lebih lanjut.',
                'is_active' => 1,
                'created_at' => '2025-09-14 21:23:26',
                'updated_at' => '2025-09-14 21:35:51',
            ],
            [
                'id' => 2,
                'title' => 'Voucher Khusus untuk Perusahaan',
                'description' => 'Kami menyediakan voucher service dan layanan on-site untuk kebutuhan kantor dan perusahaan Anda.',
                'image' => 'cms/promo/promo_1757910469.png',
                'discount_text' => null,
                'features' => '["Layanan on-site gratis","Harga khusus untuk bulk service","Support teknis 24/7","Maintenance kontrak tahunan"]',
                'button_text' => 'Hubungi Tim Corporate',
                'whatsapp_template' => 'Halo, saya ingin memanfaatkan promo diagnosa gratis + diskon sparepart 15%.',
                'is_active' => 1,
                'created_at' => '2025-09-14 21:23:26',
                'updated_at' => '2025-09-14 22:03:03',
            ],
            [
                'id' => 3,
                'title' => 'test',
                'description' => 'test testtesttesttesttesttesttesttesttesttesttesttesttesttest',
                'image' => 'cms/promo/promo_1757911569.jpg',
                'discount_text' => 'test',
                'features' => '["test","test","test","test"]',
                'button_text' => 'test',
                'whatsapp_template' => 'test',
                'is_active' => 0,
                'created_at' => '2025-09-14 21:46:09',
                'updated_at' => '2025-09-14 21:57:46',
            ],
            [
                'id' => 4,
                'title' => 'test1',
                'description' => 'test',
                'image' => 'cms/promo/promo_1757911788.jpg',
                'discount_text' => null,
                'features' => '["test"]',
                'button_text' => 'test',
                'whatsapp_template' => 'test',
                'is_active' => 0,
                'created_at' => '2025-09-14 21:49:48',
                'updated_at' => '2025-09-14 21:57:52',
            ],
        ]);
    }
}
