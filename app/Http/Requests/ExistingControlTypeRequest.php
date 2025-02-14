<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExistingControlTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->canany('master.existing_control_types.store', 'master.existing_control_types.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
        ];
    }
}
