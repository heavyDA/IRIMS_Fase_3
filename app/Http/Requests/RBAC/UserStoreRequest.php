<?php

namespace App\Http\Requests\RBAC;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
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
            'email' => 'required|email',
            'username' => 'required',
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
            'employee_id' => 'required',
            'employee_name' => 'required',
            'role' => 'required|array',
            'role.*' => 'required|in:risk admin,risk owner,risk otorisator,risk analis,risk analis pusat,risk reviewer',
            'sub_unit_code' => 'required',
            'position_name' => 'required',
            'expired_at' => 'required|date|date_format:Y-m-d',
        ];
    }
}
