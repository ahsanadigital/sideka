<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouncilCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ubah ini ke 'true' jika Anda ingin mengizinkan semua pengguna untuk membuat permintaan ini.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Kolom nama wajib diisi.',
            'name.string' => 'Kolom nama harus berupa string.',
            'name.max' => 'Kolom nama tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Kolom deskripsi wajib diisi.',
            'description.string' => 'Kolom deskripsi harus berupa string.',
            'description.max' => 'Kolom deskripsi tidak boleh lebih dari 1000 karakter.',
            'color.required' => 'Kolom warna wajib diisi.',
            'color.string' => 'Kolom warna harus berupa string.',
            'color.regex' => 'Kolom warna harus berupa kode warna hex yang valid.',
        ];
    }
}
