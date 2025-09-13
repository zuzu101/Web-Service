<?php

namespace App\Http\Requests\Cms;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'required|boolean',
        ];

        // For create or update with new image
        if ($this->isMethod('post') || $this->hasFile('image')) {
            $rules['image'] = 'required|image|mimes:jpeg,jpg,png,gif|max:2048';
        }

        return $rules;
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul layanan wajib diisi.',
            'title.string' => 'Judul layanan harus berupa teks.',
            'title.max' => 'Judul layanan maksimal 255 karakter.',
            
            'description.required' => 'Deskripsi layanan wajib diisi.',
            'description.string' => 'Deskripsi layanan harus berupa teks.',
            
            'image.required' => 'Gambar layanan wajib diupload.',
            'image.image' => 'File gambar harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat: jpeg, jpg, png, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            
            'is_active.required' => 'Status aktif wajib dipilih.',
            'is_active.boolean' => 'Status aktif harus berupa true atau false.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'judul layanan',
            'description' => 'deskripsi layanan',
            'image' => 'gambar layanan',
            'is_active' => 'status aktif',
        ];
    }
}
