<?php

namespace App\Http\Requests\Animal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAnimalRequest extends FormRequest
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
            'number' => ['required', 'string', Rule::unique('animals', 'number')->ignore($this->route('animal'))],
            'organisation_id' => 'sometimes|exists:organisations,id',
            'birthday' => 'required|date',
            'breed_id' => 'sometimes|exists:breeds,id',
            'number_rshn' => ['nullable', 'string', Rule::unique('animals', 'number_rshn')->ignore($this->route('animal'))],
            'bolus_id' => 'nullable|exists:boluses,id',
            'number_rf' => ['nullable', 'string', Rule::unique('animals', 'number_rf')->ignore($this->route('animal'))],
            'number_tavro' => ['nullable', 'string', Rule::unique('animals', 'number_tavro')->ignore($this->route('animal'))],
            'number_tag' => ['nullable', 'string', Rule::unique('animals', 'number_tag')->ignore($this->route('animal'))],
            'tag_color' => 'nullable|string',
            'entry_id'=> 'nullable|integer|exists:animal_entries,id',
            'group_id' => 'nullable|integer|exists:animal_groups,id',
            'number_collar' => 'nullable|string',
            'status_id' => 'sometimes|integer|exists:statuses,id',
            'sex' => 'nullable|in:male,female',
            'withdrawn_at' => 'nullable|date|after_or_equal:birthday',
            'is_active' => 'nullable|boolean',
        ];
    }
}
