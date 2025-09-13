<?php

namespace App\Http\Requests\Cms;

use Illuminate\Foundation\Http\FormRequest;

class AdvantageRequest extends FormRequest
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

        // For create or update with new icon
        if ($this->isMethod('post') || $this->hasFile('icon')) {
            $rules['icon'] = 'required|image|mimes:jpeg,jpg,png,gif|max:2048';
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
            'title.required' => 'Judul keunggulan wajib diisi.',
            'title.string' => 'Judul keunggulan harus berupa teks.',
            'title.max' => 'Judul keunggulan maksimal 255 karakter.',
            
            'description.required' => 'Deskripsi keunggulan wajib diisi.',
            'description.string' => 'Deskripsi keunggulan harus berupa teks.',
            
            'icon.required' => 'Icon keunggulan wajib diupload.',
            'icon.image' => 'File icon harus berupa gambar.',
            'icon.mimes' => 'Icon harus berformat: jpeg, jpg, png, atau gif.',
            'icon.max' => 'Ukuran icon maksimal 2MB.',
            
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
            'title' => 'judul keunggulan',
            'description' => 'deskripsi keunggulan',
            'icon' => 'icon keunggulan',
            'is_active' => 'status aktif',
        ];
    }
}
