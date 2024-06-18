<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAchievementRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:25',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'users_id' => 'required|exists:users,id',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'place.required' => 'Tempat wajib diisi.',
            'place.string' => 'Tempat harus berupa teks.',
            'place.max' => 'Tempat tidak boleh lebih dari 255 karakter.',

            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Tanggal harus berupa tanggal yang valid.',

            'description.string' => 'Deskripsi harus berupa teks.',

            'notes.string' => 'Catatan harus berupa teks.',

            'users_id.required' => 'ID pengguna wajib diisi.',
            'users_id.exists' => 'ID pengguna tidak valid.',

            'files.*.file' => 'Setiap file harus berupa file yang valid.',
            'files.*.mimes' => 'Setiap file harus berformat jpg, jpeg, atau png.',
            'files.*.max' => 'Setiap file tidak boleh lebih dari 2048 kilobyte.',
        ];
    }
}
