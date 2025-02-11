<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RiskTreatmentTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->roles()?->first()?->name == 'administrator';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'set_as_category' => 'boolean',
            'parent_id' => 'required_if_accepted:set_as_category|exists:risk_treatment_types,id',
            'number' => 'required',
            'name' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'set_as_category' => 'Jadikan Sebagai Kategori',
            'parent_id' => 'Kategori',
            'name' => 'Nama',
            'number' => 'Nomor',
        ];
    }
}
