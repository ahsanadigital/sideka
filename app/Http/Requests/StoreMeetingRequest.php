<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'participant' => 'required|integer|min:0',
            'date' => 'required|date',
            'category_id' => 'required|integer|exists:council_categories,id', // Assuming you have a category_id field in the form
            'users_id' => 'required|integer|exists:users,id', // Assuming you have a user_id field in the form for 'components.user-select'
            'description' => 'required|string',
            'result' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpeg,jpg,png|max:2048',
            'docs' => 'nullable|file|mimes:pdf,doc,docx,odt|max:2048',
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
            'title.required' => 'Nama Agenda wajib diisi.',
            'participant.required' => 'Jumlah Peserta wajib diisi.',
            'date.required' => 'Tanggal Kegiatan wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'description.required' => 'Deskripsi Agenda wajib diisi.',
            'users_id.required' => 'Penyelenggara Agenda wajib dipilih.',
            'result.required' => 'Hasil Rapat wajib diisi.',
            'files.*.mimes' => 'Unggah berkas harus berupa file dengan tipe: jpeg, jpg, png.',
            'files.*.max' => 'Unggah berkas tidak boleh lebih dari 2MB.',
            'docs.mimes' => 'Unggah Dokumen Hasil Rapat harus berupa file dengan tipe: pdf, doc, docx, odt.',
            'docs.max' => 'Unggah Dokumen Hasil Rapat tidak boleh lebih dari 2MB.',
        ];
    }
}
