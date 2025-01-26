<?php

namespace App\Http\Requests\Organisation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganisationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'structural_unit_id' => ['nullable', 'exists:structural_units,id'],
            'parent_id' => ['nullable', 'exists:organisations,id'],
            'is_active' => ['nullable', 'boolean'],
            'users'=> 'nullable|string',
            'abbreviated'=> 'nullable|string',
            'inn'=> 'nullable|integer',
            'region'=> 'nullable|string',
            'district'=> 'nullable|string',
            'adress'=> 'nullable|string',
            'uuid'=>'nullable|string',
            'category_actives_id' => 'nullable|integer|exists:category_actives,id',
            'department'=>'nullable|string',
        ];
    }
}
