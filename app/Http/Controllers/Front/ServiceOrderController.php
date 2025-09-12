<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ServiceOrderRequest;
use App\Models\MasterData\Customers;
use App\Models\MasterData\DeviceRepair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends Controller
{
    /**
     * Store service order from front-end form
     *
     * @param  ServiceOrderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ServiceOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create or find customer
            $customer = Customers::where('email', $request->email)->first();
            
            if (!$customer) {
                $customer = Customers::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'province_id' => $request->province_id,
                    'regency_id' => $request->regency_id,
                    'district_id' => $request->district_id,
                    'village_id' => $request->village_id,
                    'street_address' => $request->street_address,
                    'status' => 1, // Active by default
                ]);
            } else {
                // Update customer data if exists
                $customer->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'province_id' => $request->province_id,
                    'regency_id' => $request->regency_id,
                    'district_id' => $request->district_id,
                    'village_id' => $request->village_id,
                    'street_address' => $request->street_address,
                ]);
            }

            // Generate nota number
            $latestNota = DeviceRepair::latest('id')->first();
            $nextNumber = $latestNota ? $latestNota->id + 1 : 1;
            $notaNumber = 'NOTA-' . date('Ym') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Create device repair record
            DeviceRepair::create([
                'nota_number' => $notaNumber,
                'customer_id' => $customer->id,
                'brand' => $request->brand,
                'model' => $request->model,
                'serial_number' => $request->serial_number,
                'reported_issue' => $request->reported_issue,
                'technician_note' => '-',
                'status' => 'Perangkat Baru Masuk',
                'price' => null,
                'complete_in' => null,
            ]);

            DB::commit();

                        // Prepare WhatsApp message with better formatting and user perspective
            $waNumber = env('SERVICE_WHATSAPP_NUMBER', '6287823330830');
            $messageLines = [
                "*PERMINTAAN SERVICE LAPTOP*",
                "",
                "Halo, saya ingin mengajukan service laptop dengan detail berikut:",
                "",
                "*Data Pelanggan:*",
                "• Nama: {$request->name}",
                "• WhatsApp: {$request->phone}",
                "• Email: {$request->email}",
                "• Alamat: {$request->address}",
                "",
                "*Detail Perangkat:*",
                "• Merk: {$request->brand}",
                "• Model/Series: {$request->model}",
                "• Serial Number: {$request->serial_number}",
                "",
                "*Keluhan/Masalah:*",
                "{$request->reported_issue}",
                "",
                "*Nomor Nota: {$notaNumber}*",
                "",
                "Mohon informasi selanjutnya. Terima kasih..."
            ];

            $waText = implode("\n", $messageLines);
            $waUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $waNumber) . '?text=' . rawurlencode($waText);

            return response()->json([
                'success' => true,
                'message' => 'Permintaan service berhasil dikirim! Kami akan segera menghubungi Anda.',
                'nota_number' => $notaNumber,
                'wa_url' => $waUrl
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi atau hubungi customer service.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store service order from chatbot
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeChatbot(Request $request)
    {
        try {
            // Validate chatbot specific fields
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'reported_issue' => 'required|string'
            ]);

            DB::beginTransaction();

            // Create customer from chatbot data (using phone as identifier)
            // For chatbot, we'll always create new customer record to avoid conflicts
            $customer = Customers::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email ?? '-', // No unique constraint now
                'address' => $request->address ?? '-',
                'status' => 1,
            ]);

            // Generate nota number
            $latestNota = DeviceRepair::latest('id')->first();
            $nextNumber = $latestNota ? $latestNota->id + 1 : 1;
            $notaNumber = 'NOTA-' . date('Ym') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Create device repair record
            DeviceRepair::create([
                'nota_number' => $notaNumber,
                'customer_id' => $customer->id,
                'brand' => $request->brand,
                'model' => $request->model,
                'serial_number' => $request->serial_number ?? '-',
                'reported_issue' => $request->reported_issue,
                'technician_note' => $request->technician_note ?? 'Pemesanan via Chatbot LASO',
                'status' => 'Perangkat Baru Masuk',
                'price' => null,
                'complete_in' => null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan ke database!',
                'nota_number' => $notaNumber
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle chatbot WhatsApp click tracking
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function klikWa(Request $request)
    {
        // Simple endpoint for tracking WhatsApp clicks
        // You can add analytics or logging here if needed
        return response()->json([
            'success' => true,
            'message' => 'WhatsApp click tracked'
        ]);
    }
}
