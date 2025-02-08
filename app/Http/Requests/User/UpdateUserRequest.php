<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'lastname' => 'nullable|string',
            'phone' => 'nullable|string',
            'surname' => 'nullable|string',
            'roles_names' => 'nullable|string',
            // 'uuid' => 'nullable|string',
            'password' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];
    }
}
