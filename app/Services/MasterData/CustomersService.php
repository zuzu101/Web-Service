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
            Customers::create($request->all());
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
        $array = $customers->orderBy('id', 'desc')->get(['id', 'name', 'email', 'phone', 'address', 'status']);

        $data = [];
        $no = 0;

        foreach ($array as $item) {
            //customers table
            $nestedData['no'] = ++$no;
            $nestedData['name'] = $item->name;
            $nestedData['email'] = $item->email;
            $nestedData['phone'] = $item->phone;
            $nestedData['address'] = $item->address;
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
