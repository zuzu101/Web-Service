<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class CustomersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|max:255',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'nullable|exists:districts,id',
            'village_id' => 'nullable|exists:villages,id',
            'street_address' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500', // Keep for backward compatibility
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.numeric' => 'Nomor telepon hanya boleh berisi angka.',
            'phone.digits_between' => 'Nomor telepon harus antara 10-15 digit.',
            'email.email' => 'Format email tidak valid.',
            'province_id.required' => 'Provinsi harus dipilih.',
            'province_id.exists' => 'Provinsi yang dipilih tidak valid.',
            'regency_id.required' => 'Kabupaten/Kota harus dipilih.',
            'regency_id.exists' => 'Kabupaten/Kota yang dipilih tidak valid.',
            'district_id.exists' => 'Kecamatan yang dipilih tidak valid.',
            'village_id.exists' => 'Desa/Kelurahan yang dipilih tidak valid.',
            'status.in' => 'Status harus Active atau Inactive.',
        ];
    }
}
