<?php

namespace App\Http\Requests\RBAC;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
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
            'username' => 'required|unique:users,username' . (request('user') ? ',' . request('user')->id : ''),
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
            'employee_id' => 'required|unique:users,employee_id' . (request('user') ? ',' . request('user')->id : ''),
            'employee_name' => 'required',
            'role' => 'required|array',
            'role.*' => 'in:risk admin,risk owner,risk otorisator,risk analis,risk reviewer',
            'sub_unit_code' => 'required',
            'position_name' => 'required',
        ];
    }
}
