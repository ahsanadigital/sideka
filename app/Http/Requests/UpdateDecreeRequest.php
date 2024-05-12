<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDecreeRequest extends FormRequest
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
            'document' => 'nullable|file|max:4096',
            'public' => 'required|boolean',
        ];
    }
}
