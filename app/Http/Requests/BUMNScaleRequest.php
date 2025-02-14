<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BUMNScaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->canany('master.bumn_scales.store', 'master.bumn_scales.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'impact_category' => 'required|in:kualitatif,kuantitatif',
            'scale' => 'required|numeric',
            'criteria' => 'required',
            'description' => 'required',
            'min' => 'required|numeric|max:99|min:0|lt:max',
            'max' => 'required|numeric|max:100|min:1|gt:min',
        ];
    }

    public function attributes(): array
    {
        return [
            'impact_category' => 'Kategori',
            'scale' => 'Skala',
            'criteria' => 'Kriteria',
            'description' => 'Deskripsi',
            'min' => 'Nilai Minimal',
            'max' => 'Nilai Maksimal',
        ];
    }
}
