<?php

namespace App\Services\MasterData;

use App\Helpers\ErrorHandling;
use App\Helpers\ImageHelpers;
use App\Http\Requests\MasterData\DeviceRepairRequest;
use App\Models\MasterData\DeviceRepair;
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
            DeviceRepair::create($request->all());
        } catch (\Error $e) {
            ErrorHandling::environmentErrorHandling($e->getMessage());
        }
    }

    public function update(DeviceRepairRequest $request, DeviceRepair $deviceRepair)
    {
        $request->validated();

        try {
            $deviceRepair->update($request->all());
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
        
        $array = $query->get(['id', 'customer_id', 'brand', 'model', 'reported_issue', 'serial_number', 'technician_note', 'status', 'price', 'complete_in']);

        $data = [];
        $no = 0;

        foreach ($array as $item) {
            $no++;
            $nestedData['no'] = $no;
            $nestedData['pelanggan_name'] = $item->customers ? $item->customers->name : 'No Customers';
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

        return DataTables::of($data)->rawColumns(["actions", "status", "ubah_status"])->toJson();
    }
}
