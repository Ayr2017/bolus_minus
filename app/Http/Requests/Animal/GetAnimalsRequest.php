<?php

namespace App\Http\Requests\Animal;

use Illuminate\Foundation\Http\FormRequest;

class GetAnimalsRequest extends FormRequest
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
            'per_page' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
            'select' => 'nullable|array',
            'bolus_number'=>'nullable|string|exists:boluses,number',
            'number' => 'nullable|string',
            'number_rshn' => 'nullable|string',
            'number_tavro' => 'nullable|string',
            'bolus_active'=>'nullable|boolean',
        ];
    }
}
