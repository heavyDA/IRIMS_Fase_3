<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return role()->checkPermission('setting.positions.create') || role()->checkPermission('setting.positions.update') || role()->checkPermission('setting.positions.destroy');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sub_unit_code' => 'required|exists:m_positions,sub_unit_code',
            'position_name' => 'required',
            'roles' => 'required|array|min:1',
            'roles.*' => 'required|exists:roles,name',
        ];
    }
}
