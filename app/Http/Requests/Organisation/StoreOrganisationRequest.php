<?php

namespace App\Http\Requests\Organisation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ActivityCategory;

class StoreOrganisationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'structural_unit_id' => ['nullable', 'exists:structural_units,id'],
            'parent_id' => ['nullable', 'exists:organisations,id'],
            'is_active' => ['nullable', 'boolean'],
            'address' => 'required|string',
            // 'uuid' => 'nullable|string',
            'activity_category' => ['required', Rule::enum(ActivityCategory::class)],
        ];
    }
}
