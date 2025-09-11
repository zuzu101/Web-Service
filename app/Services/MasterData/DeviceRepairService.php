<?php

namespace App\Services\MasterData;

use App\Helpers\ErrorHandling;
use App\Helpers\ImageHelpers;
use App\Http\Requests\MasterData\DeviceRepairRequest;
use App\Models\MasterData\DeviceRepair;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DeviceRepairService
{
    protected $imageHelper;
    public function __construct() {
        $this->imageHelper = new ImageHelpers('back_assets/img/MasterData/DeviceRepair/');
    }

    public function store(DeviceRepairRequest $request) {
        $request->validated();

        try {
            $data = $request->all();
            
            // Handle new customer creation
            if (isset($data['customer_id']) && strpos($data['customer_id'], 'new:') === 0) {
                $customerName = substr($data['customer_id'], 4); // Remove 'new:' prefix
                
                // Create new customer with minimal data
                $customer = \App\Models\MasterData\Customers::create([
                    'name' => $customerName,
                    'phone' => '', // Will be updated later if needed
                    'address' => '', // Will be updated later if needed
                    'status' => 1 // Active by default
                ]);
                
                $data['customer_id'] = $customer->id;
            }
            
            // Handle transfer proof file upload
            if ($request->hasFile('transfer_proof')) {
                $file = $request->file('transfer_proof');
                $filename = 'transfer_proof_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('transfer_proofs', $filename, 'public');
                $data['transfer_proof'] = $path;
            }
            
            DeviceRepair::create($data);
        } catch (\Error $e) {
            ErrorHandling::environmentErrorHandling($e->getMessage());
        }
    }

    public function update(DeviceRepairRequest $request, DeviceRepair $deviceRepair)
    {
        $request->validated();

        try {
            $data = $request->all();
            
            // Handle new customer creation
            if (isset($data['customer_id']) && strpos($data['customer_id'], 'new:') === 0) {
                $customerName = substr($data['customer_id'], 4); // Remove 'new:' prefix
                
                // Create new customer with minimal data
                $customer = \App\Models\MasterData\Customers::create([
                    'name' => $customerName,
                    'phone' => '', // Will be updated later if needed
                    'address' => '', // Will be updated later if needed
                    'status' => 1 // Active by default
                ]);
                
                $data['customer_id'] = $customer->id;
            }
            
            // Handle transfer proof file upload
            if ($request->hasFile('transfer_proof')) {
                // Delete old file if exists
                if ($deviceRepair->transfer_proof && Storage::disk('public')->exists($deviceRepair->transfer_proof)) {
                    Storage::disk('public')->delete($deviceRepair->transfer_proof);
                }
                
                $file = $request->file('transfer_proof');
                $filename = 'transfer_proof_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('transfer_proofs', $filename, 'public');
                $data['transfer_proof'] = $path;
            }
            
            $deviceRepair->update($data);
        } catch (\Error $e) {
            ErrorHandling::environmentErrorHandling($e->getMessage());
        }
    }

    public function destroy(DeviceRepair $deviceRepair) {
        try {
            $deviceRepair->delete();
        } catch (\Error $e) {
            ErrorHandling::environmentErrorHandling($e->getMessage());
        }
    }

    public function data(object $deviceRepair, $request = null)
    {
        $query = $deviceRepair->with('customers')->orderBy('id', 'desc');
        
        // Apply status filter if provided (dipindah dari StatusService)
        if ($request && $request->has('status_filter') && $request->status_filter != '') {
            $query->where('status', $request->status_filter);
        }
        
        $array = $query->get(['id', 'nota_number', 'customer_id', 'brand', 'model', 'reported_issue', 'serial_number', 'technician_note', 'status', 'price', 'complete_in', 'payment_method', 'transfer_proof', 'created_at']);

        $data = [];
        $no = 0;

        foreach ($array as $item) {
            $no++;
            $nestedData['no'] = $no;
            $nestedData['pelanggan_name'] = $item->customers ? $item->customers->name : 'No Customers';
            
            // Generate nota number - sama seperti di NotaService
            $nestedData['nota_number'] = $item->nota_number ?: 'NOTA-' . date('Ym', strtotime($item->created_at)) . '-' . str_pad($item->id, 3, '0', STR_PAD_LEFT);
            
            $nestedData['brand'] = $item->brand;
            $nestedData['model'] = $item->model;
            $nestedData['reported_issue'] = $item->reported_issue;
            $nestedData['serial_number'] = $item->serial_number;
            $nestedData['technician_note'] = $item->technician_note ?: '-';
            
            // Add colored status badge
            $currentStatus = $item->status ?: 'Perangkat Baru Masuk';
            $statusClass = '';
            switch($currentStatus) {
                case 'Selesai':
                    $statusClass = 'badge bg-success';
                    break;
                case 'Sedang Diperbaiki':
                    $statusClass = 'badge bg-warning';
                    break;
                case 'Perangkat Baru Masuk':
                    $statusClass = 'badge bg-secondary';
                    break;
                default:
                    $statusClass = 'badge bg-secondary';
            }
            $nestedData['status'] = '<span class="' . $statusClass . '">' . $currentStatus . '</span>';
            
            $nestedData['price'] = $item->price ? 'Rp. ' . number_format($item->price, 0, ',', '.') : '-';
            $nestedData['complete_in'] = $item->complete_in ? $item->complete_in->format('d/m/Y') : '-';
            
            // Payment method column
            $nestedData['payment_method'] = $item->payment_method ? ucfirst($item->payment_method) : '-';
            
            // Transfer proof column
            if ($item->payment_method === 'transfer' && $item->transfer_proof) {
                // Check if file is image or PDF
                $fileExtension = pathinfo($item->transfer_proof, PATHINFO_EXTENSION);
                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $isImage = in_array(strtolower($fileExtension), $imageExtensions);
                
                if ($isImage) {
                    $nestedData['transfer_proof'] = '<a href="' . Storage::url($item->transfer_proof) . '" target="_blank" class="btn btn-outline-success btn-sm">
                        <i class="fa fa-image"></i> Lihat
                    </a>';
                } else {
                    $nestedData['transfer_proof'] = '<a href="' . Storage::url($item->transfer_proof) . '" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="fa fa-file-pdf"></i> PDF
                    </a>';
                }
            } else {
                $nestedData['transfer_proof'] = '-';
            }
            
            // Tambahkan kolom "Ubah Status" (pindahan dari Status page) + Action asli
            $statusButton = '';
            if ($currentStatus == 'Perangkat Baru Masuk') {
                $statusButton = '<a href="javascript:void(0)" onclick="updateStatus(' . $item->id . ', \'Sedang Diperbaiki\')" class="btn btn-outline-warning btn-sm mb-1" title="Mulai Perbaikan">
                        <i class="fa fa-cog"></i> Mulai
                    </a>';
            } elseif ($currentStatus == 'Sedang Diperbaiki') {
                $statusButton = '<a href="javascript:void(0)" onclick="updateStatus(' . $item->id . ', \'Selesai\')" class="btn btn-outline-success btn-sm mb-1" title="Selesaikan">
                        <i class="fa fa-check"></i> Selesai
                    </a>';
            } elseif ($currentStatus == 'Selesai') {
                $statusButton = '<a href="' . route('admin.MasterData.DeviceRepair.preview', $item->id) . '" class="btn btn-outline-info btn-sm mb-1" title="Preview Detail">
                        <i class="fa fa-eye"></i> Detail
                    </a>';
            }
            
            $nestedData['ubah_status'] = '<div class="text-center">' . $statusButton . '</div>';
            
            // Kolom Nota Actions (Print & PDF) - sama seperti di NotaService
            $nestedData['nota_actions'] = '
                <div class="btn-group">
                    <button class="btn btn-outline-info btn-sm d-inline-flex align-items-center btn-print" 
                            data-id="' . $item->id . '" 
                            data-price="' . ($item->price ?: 0) . '" 
                            data-customer="' . ($item->customers ? $item->customers->name : 'No Customer') . '"
                            data-device="' . $item->brand . ' ' . $item->model . '">
                        Print <i class="fa fa-print ml-2"></i> 
                    </button>
                    <button class="btn btn-outline-danger btn-sm d-inline-flex align-items-center btn-pdf" 
                            data-id="' . $item->id . '" 
                            data-price="' . ($item->price ?: 0) . '" 
                            data-customer="' . ($item->customers ? $item->customers->name : 'No Customer') . '"
                            data-device="' . $item->brand . ' ' . $item->model . '">
                        PDF <i class="fa fa-file-pdf ml-2"></i>
                    </button>
                </div>
            ';
            
            $nestedData['actions'] = '
                <div class="btn-group-vertical">
                <a href="' . route('admin.MasterData.DeviceRepair.edit', $item) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <a href="javascript:void(0)" onclick="deleteDeviceRepair(' . $item->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                    <i class="fas fa-trash mr-1"></i> Hapus
                </a>
                </div>
            ';

            $data[] = $nestedData;
        }

        return DataTables::of($data)->rawColumns(["actions", "status", "ubah_status", "nota_actions", "transfer_proof"])->toJson();
    }
}
