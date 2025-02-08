<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
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
            'password' => 'required|string',
            'uuid' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];
    }
}
