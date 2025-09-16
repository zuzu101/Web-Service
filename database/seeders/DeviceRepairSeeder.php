<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MasterData\DeviceRepair;
use App\Models\MasterData\Customers;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DeviceRepairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('device_repairs')->delete();
        $faker = Faker::create('id_ID');
        $brands = ['ASUS', 'Acer', 'HP', 'Lenovo', 'Dell', 'Apple', 'Toshiba', 'Samsung', 'MSI', 'Huawei'];
        $models = ['VivoBook', 'Swift', 'Pavilion', 'ThinkPad', 'Inspiron', 'MacBook', 'Satellite', 'Galaxy Book', 'Modern', 'MateBook'];
        $issues = [
            'Touchpad tidak responsif',
            'Audio tidak keluar suara',
            'Speaker pecah',
            'Keyboard error',
            'WiFi tidak terdeteksi',
            'Tidak bisa charging',
            'Overheating',
            'Layar bergaris',
            'Tidak bisa booting',
            'Baterai cepat habis',
            'Port USB rusak',
            'Layar blank',
            'CD/DVD ROM tidak terbaca',
            'Webcam tidak berfungsi',
            'Hard disk error',
            'Kipas berisik',
            'Charger tidak mengisi',
            'Windows corrupt',
            'Install ulang Windows',
            'Virus dan malware berat'
        ];
        $notes = [
            'Update BIOS dan driver terbaru',
            'Ganti baterai',
            'Ganti panel LCD',
            'Ganti keyboard',
            'Ganti IC charging',
            'Bersihkan fan dan ganti thermal paste',
            'Ganti modul WiFi',
            'Ganti speaker',
            'Ganti harddisk',
            'Pembersihan virus dan optimasi sistem',
            'Ganti kipas processor',
            'Perbaikan port USB',
            'Ganti RAM',
            'Cleaning dan re-apply thermal compound',
            'Motherboard perlu penggantian komponen',
            'Perbaikan jalur charging',
            'Penggantian layar LCD',
            'Install ulang Windows 11 dan driver lengkap',
            'Perbaikan engsel layar',
            'Update software keamanan'
        ];
        $statuses = ['Perangkat Baru Masuk', 'Sedang Diperbaiki', 'Selesai'];
        $payment_methods = ['Cash', 'Transfer', null];

        // Ambil semua pelanggan
        $customers = \DB::table('customers')->get();
        $deviceRepairs = [];
        for ($i = 1; $i <= 200; $i++) {
            $customer = $customers->random();
            $brand = $faker->randomElement($brands);
            $model = $faker->randomElement($models) . ' ' . $faker->numberBetween(1000,9999);
            $serial = strtoupper($faker->bothify('??#####'));
            $issue = $faker->randomElement($issues);
            $note = $faker->randomElement($notes);
            $status = $faker->randomElement($statuses);
            // Harga dibulatkan ke bawah kelipatan 1000
            $price = null;
            if ($status === 'Selesai') {
                $rawPrice = $faker->numberBetween(150000, 2000000);
                $price = floor($rawPrice / 1000) * 1000;
            }
            $payment_method = $status === 'Selesai' ? $faker->randomElement($payment_methods) : null;
            $transfer_proof = ($payment_method === 'Transfer' && $status === 'Selesai') ? 'bukti_transfer_' . $i . '.jpg' : null;

            // Tanggal random antara 1 Sep 2025 - 31 Des 2025
            $start = strtotime('2025-09-01');
            $end = strtotime('2025-12-31');
            $created_at = $faker->dateTimeBetween('@'.$start, '@'.$end);
            $updated_at = (clone $created_at)->modify('+' . $faker->numberBetween(0, 7) . ' days');
            $complete_in = $status === 'Selesai' ? $updated_at->format('Y-m-d') : null;

            // Email dari nama pelanggan
            $nama_email = strtolower(preg_replace('/[^a-z0-9]/', '', str_replace(' ', '', $customer->name)));
            $email = $nama_email . '@mail.com';

            $deviceRepairs[] = [
                'id' => $i,
                'nota_number' => 'NOTA-2025' . $created_at->format('m') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'customer_id' => $customer->id,
                'brand' => $brand,
                'model' => $model,
                'reported_issue' => $issue,
                'serial_number' => $serial,
                'technician_note' => $note,
                'status' => $status,
                'price' => $price,
                'payment_method' => $payment_method,
                'transfer_proof' => $transfer_proof,
                'complete_in' => $complete_in,
                'created_at' => $created_at->format('Y-m-d H:i:s'),
                'updated_at' => $updated_at->format('Y-m-d H:i:s'),
            ];
        }
        DB::table('device_repairs')->insert($deviceRepairs);
    }
}
