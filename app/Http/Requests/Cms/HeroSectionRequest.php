<?php

namespace App\Http\Requests\Cms;

use Illuminate\Foundation\Http\FormRequest;

class HeroSectionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'title2' => 'nullable|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ];

        // Image validation rules
        if ($this->isMethod('post')) {
            // For create, images can be required
            $rules['image1'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        } else {
            // For update, images are optional
            $rules['image1'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        return $rules;
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'title2.string' => 'Judul 2 harus berupa teks.',
            'title2.max' => 'Judul 2 maksimal 255 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'image1.image' => 'File gambar harus berupa gambar.',
            'image1.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif, webp.',
            'image1.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'Judul',
            'title2' => 'Judul 2',
            'description' => 'Deskripsi',
            'image1' => 'Gambar',
            'is_active' => 'Status Aktif',
        ];
    }
}