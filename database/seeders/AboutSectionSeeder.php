<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AboutSectionSeeder extends Seeder
{
    public function run()
    {
        DB::table('about_sections')->truncate();
        DB::table('about_sections')->insert([
            [
                'id' => 1,
                'title' => 'Tentang Kami',
                'image' => 'about/about_1757918709.jpg',
                'content' => '<p>Kami adalah tim teknisi laptop profesional yang berdedikasi untuk memberikan layanan terbaik sejak 2010. Dengan pengalaman bertahun-tahun dan ribuan laptop yang telah kami tangani, kami mengutamakan kejujuran, transparansi, dan kualitas.</p><p>Kami percaya bahwa laptop Anda bukan sekadar alat kerja, tapi aset penting yang harus dijaga. Setiap perangkat memiliki cerita dan memori berharga bagi pemiliknya. Itulah mengapa kami memperlakukan setiap perbaikan dengan penuh perhatian dan profesionalisme.</p><p>Tim kami terdiri dari teknisi bersertifikat yang terus mengikuti perkembangan teknologi terbaru. Kami menggunakan alat diagnostik mutakhir dan komponen berkualitas tinggi untuk memastikan laptop Anda kembali berfungsi optimal.</p><ul><li><strong>Kejujuran -&nbsp;</strong>Diagnosa masalah yang transparan tanpa biaya tersembunyi.</li><li><strong>Profesionalisme -&nbsp;</strong>Teknisi bersertifikasi dengan pelatihan berkala.</li><li><strong>Garansi -&nbsp;</strong>Jaminan 90 hari untuk setiap perbaikan.</li><li><strong>Efisiensi -&nbsp;</strong>Waktu perbaikan cepat tanpa mengorbankan kualitas.</li></ul><p><br></p>',
                'is_active' => 0,
                'created_at' => '2025-09-14 23:36:32',
                'updated_at' => '2025-09-15 01:09:06',
            ],
            [
                'id' => 2,
                'title' => 'Tentang Kami',
                'image' => null,
                'content' => '<p>Kami adalah tim teknisi laptop profesional yang berdedikasi untuk memberikan layanan terbaik sejak 2010. Dengan pengalaman bertahun-tahun dan ribuan laptop yang telah kami tangani, kami mengutamakan kejujuran, transparansi, dan kualitas.</p><p>Kami percaya bahwa laptop Anda bukan sekadar alat kerja, tapi aset penting yang harus dijaga. Setiap perangkat memiliki cerita dan memori berharga bagi pemiliknya. Itulah mengapa kami memperlakukan setiap perbaikan dengan penuh perhatian dan profesionalisme.</p><p>Tim kami terdiri dari teknisi bersertifikat yang terus mengikuti perkembangan teknologi terbaru. Kami menggunakan alat diagnostik mutakhir dan komponen berkualitas tinggi untuk memastikan laptop Anda kembali berfungsi optimal.</p><ul><li><strong>Kejujuran -&nbsp;</strong>Diagnosa masalah yang transparan tanpa biaya tersembunyi.</li><li><strong>Profesionalisme -&nbsp;</strong>Teknisi bersertifikasi dengan pelatihan berkala.</li><li><strong>Garansi -&nbsp;</strong>Jaminan 90 hari untuk setiap perbaikan.</li><li><strong>Efisiensi -&nbsp;</strong>Waktu perbaikan cepat tanpa mengorbankan kualitas.</li></ul><p><br></p>',
                'is_active' => 1,
                'created_at' => '2025-09-14 23:36:42',
                'updated_at' => '2025-09-15 01:09:06',
            ],
        ]);
    }
}
