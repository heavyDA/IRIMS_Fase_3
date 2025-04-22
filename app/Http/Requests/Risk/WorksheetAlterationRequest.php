<?php

namespace App\Http\Requests\Risk;

use Illuminate\Foundation\Http\FormRequest;

class WorksheetAlterationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'worksheet_id' => ['required', 'numeric', 'exists:ra_worksheets,id'],
            'body' => 'required',
            'impact' => 'required',
            'description' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'worksheet_id' => 'Profil Risiko',
            'body' => 'Jenis Perubahan',
            'impact' => 'Peristiwa Risiko yang Terdampak atas Perubahan',
            'description' => 'Penjelasan',
        ];
    }
}
