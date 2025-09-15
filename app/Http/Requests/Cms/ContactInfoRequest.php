<?php

namespace App\Http\Requests\Cms;

use Illuminate\Foundation\Http\FormRequest;

class ContactInfoRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'link' => 'nullable|url',
            'is_active' => 'required|boolean'
        ];

        // Icon validation rules
        if ($this->isMethod('post')) {
            // For create: icon file is required
            $rules['icon'] = 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048';
        } else {
            // For update: icon file is optional
            $rules['icon'] = 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048';
        }

        return $rules;
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'icon.required' => 'Icon wajib diupload',
            'icon.image' => 'File harus berupa gambar',
            'icon.mimes' => 'Format gambar harus: jpeg, jpg, png, gif, atau svg',
            'icon.max' => 'Ukuran gambar maksimal 2MB',
            'title.required' => 'Judul wajib diisi',
            'title.max' => 'Judul maksimal 255 karakter',
            'content.required' => 'Konten wajib diisi',
            'link.url' => 'Format link tidak valid',
            'is_active.required' => 'Status wajib dipilih',
            'is_active.boolean' => 'Status harus berupa true atau false'
        ];
    }
}
