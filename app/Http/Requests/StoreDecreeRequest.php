<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDecreeRequest extends FormRequest
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
            'number' => 'required|string|max:255',
            'title' => 'required|max:255|string',
            'nomenclature' => 'required|string',
            'start_from' => 'date|required',
            'users_id' => 'required|exists:users,id',
            'end_to' => 'date|nullable|after_or_equal:start_from',
            'document' => 'required|file|max:4096',
            'public' => 'required|boolean',
            'category_id' => 'required|exists:council_categories,id'
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
            'number.required' => 'Nomor wajib diisi.',
            'number.string' => 'Nomor harus berupa teks.',
            'number.max' => 'Nomor tidak boleh lebih dari 255 karakter.',

            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',

            'nomenclature.required' => 'Nomenklatur wajib diisi.',
            'nomenclature.string' => 'Nomenklatur harus berupa teks.',

            'start_from.required' => 'Tanggal mulai wajib diisi.',
            'start_from.date' => 'Tanggal mulai harus berupa tanggal yang valid.',

            'users_id.required' => 'ID pengguna wajib diisi.',
            'users_id.exists' => 'ID pengguna tidak valid.',

            'end_to.date' => 'Tanggal selesai harus berupa tanggal yang valid.',
            'end_to.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',

            'document.required' => 'Dokumen wajib diunggah.',
            'document.file' => 'Dokumen harus berupa file yang valid.',
            'document.max' => 'Dokumen tidak boleh lebih dari 4096 kilobyte.',

            'public.required' => 'Status publik wajib diisi.',
            'public.boolean' => 'Status publik harus berupa nilai benar atau salah.',

            'category_id.required' => 'ID kategori wajib diisi.',
            'category_id.exists' => 'ID kategori tidak valid.',
        ];
    }
}
