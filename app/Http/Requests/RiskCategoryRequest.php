<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RiskCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->canany('master.risk_categories.store', 'master.risk_categories.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:T2,T3',
            'name' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'Tipe',
            'name' => 'Nama',
        ];
    }
}
