<?php

namespace App\Services\MasterData;

use App\Helpers\ErrorHandling;
use App\Helpers\ImageHelpers;
use App\Http\Requests\MasterData\CustomersRequest;
use App\Models\MasterData\Customers;
use Yajra\DataTables\Facades\DataTables;

class CustomersService
{
    protected $imageHelper;
    public function __construct() {
        $this->imageHelper = new ImageHelpers('back_assets/img/MasterData/Customers/');
    }

    public function store(CustomersRequest $request) {
        $request->validated();

        try {
            $data = $request->all();
            
            // Generate full address for backward compatibility
            if (!empty($data['province_id']) || !empty($data['regency_id'])) {
                $addressParts = [];
                
                if (!empty($data['street_address'])) {
                    $addressParts[] = $data['street_address'];
                }
                
                // Get region names for address
                if (!empty($data['village_id'])) {
                    $village = \App\Models\Village::find($data['village_id']);
                    if ($village) $addressParts[] = $village->name;
                }
                
                if (!empty($data['district_id'])) {
                    $district = \App\Models\District::find($data['district_id']);
                    if ($district) $addressParts[] = $district->name;
                }
                
                if (!empty($data['regency_id'])) {
                    $regency = \App\Models\Regency::find($data['regency_id']);
                    if ($regency) $addressParts[] = $regency->name;
                }
                
                if (!empty($data['province_id'])) {
                    $province = \App\Models\Province::find($data['province_id']);
                    if ($province) $addressParts[] = $province->name;
                }
                
                $data['address'] = implode(', ', $addressParts);
            }
            
            Customers::create($data);
        } catch (\Error $e) {
            ErrorHandling::environmentErrorHandling($e->getMessage());
        }
    }

    public function update(CustomersRequest $request, Customers $customer)
    {
        $request->validated();

        try {
            $customer->update($request->all());
        } catch (\Error $e) {
            ErrorHandling::environmentErrorHandling($e->getMessage());
        }
    }

    public function destroy(Customers $customer) {
        try {
            $customer->delete();
        } catch (\Error $e) {
            ErrorHandling::environmentErrorHandling($e->getMessage());
        }
    }

    public function data(object $customers)
    {
        $array = $customers->with(['province', 'regency', 'district', 'village'])->orderBy('id', 'desc')->get(['id', 'name', 'email', 'phone', 'address', 'province_id', 'regency_id', 'district_id', 'village_id', 'street_address', 'status']);

        $data = [];
        $no = 0;

        foreach ($array as $item) {
            //customers table
            $nestedData['no'] = ++$no;
            $nestedData['name'] = $item->name;
            $nestedData['email'] = $item->email;
            $nestedData['phone'] = $item->phone;
            
            // Use full_address accessor or fallback to old address
            $nestedData['address'] = $item->full_address ?: $item->address ?: '-';
            
            $nestedData['status'] = $item->status ? 'Active' : 'Inactive';
            $nestedData['actions'] = '
            <div class="btn-group">
                <a href="' . route('admin.MasterData.customers.edit', $item) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center">
                    Edit <i class="fas fa-edit ml-2"></i>
                </a>
                <a href="javascript:void(0)" onclick="deleteCustomer(' . $item->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                    Hapus <i class="fas fa-trash ml-2"></i>
                </a>
            </div>
            ';

            $data[] = $nestedData;
        }

        return DataTables::of($data)->rawColumns(["actions", "status"])->toJson();
    }
}
