<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRepairRequest extends FormRequest
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
            'customer_id' => 'required', // Remove exists validation to allow new customers
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'reported_issue' => 'required|string',
            'serial_number' => 'required|string|max:255',
            'technician_note' => 'nullable|string',
            'status' => 'required|string|in:Perangkat Baru Masuk,Sedang Diperbaiki,Menunggu Spare Part,Selesai,Siap Diambil,Sudah Diambil',
            'price' => 'nullable|numeric|min:0',
            'complete_in' => 'nullable|date',
            'payment_method' => 'required|in:cash,transfer',
            'transfer_proof' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048', // 2MB max
        ];
    }

    /**
     * Custom validation for transfer proof requirement
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('payment_method') === 'transfer' && !$this->hasFile('transfer_proof') && !$this->filled('existing_transfer_proof')) {
                $validator->errors()->add('transfer_proof', 'Bukti transfer wajib diupload untuk pembayaran transfer.');
            }
        });
    }
}
