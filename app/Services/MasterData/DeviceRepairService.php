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

    public function data(object $deviceRepair)
    {
        $array = $deviceRepair->with('customers')->orderBy('id', 'desc')->get(['id', 'customer_id', 'brand', 'model', 'reported_issue', 'serial_number', 'technician_note', 'status', 'price', 'complete_in']);

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
            $nestedData['actions'] = '
                <div class="btn-group">
                <a href="' . route('admin.MasterData.DeviceRepair.edit', $item) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center">
                    Edit <i class="fas fa-edit ml-2"></i>
                </a>
                <a href="javascript:void(0)" onclick="deleteDeviceRepair(' . $item->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                    Hapus <i class="fas fa-trash ml-2"></i>
                </a>
                </div>
            ';

            $data[] = $nestedData;
        }

        return DataTables::of($data)->rawColumns(["actions", "status"])->toJson();
    }
}
