<?php

namespace App\Http\Requests\AnimalGroup;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimalGroupRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:animal_groups,name'],
            'description' => ['nullable', 'string'],
            'is_active'=>'required|boolean',
        ];
    }
}
