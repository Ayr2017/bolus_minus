<?php

namespace App\Http\Requests\Animal;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimalRequest extends FormRequest
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
            'number' => 'required|string|unique:animals,number',
            'organisation_id' => 'required|exists:organisations,id',
            'birthday' => 'required|date',
            'breed_id' => 'required|exists:breeds,id',
            'number_rshn' => 'required|string|unique:animals,number_rshn',
            'bolus_id' => 'required|exists:boluses,id',
            'number_rf'=>'required|string|unique:animals,number_rf',
            'number_tavro' => 'required|string|unique:animals,number_tavro',
            'number_tag'=>'required|string|unique:animals,number_tag',
            'tag_color' => 'required|string',
            'number_collar'=>'required|string',
            'status_id' => 'required|integer|exists:statuses,id',
            'sex'=>'required|in:male,female',
            'withdrawn_at'=>'nullable|date',
        ];
    }
}

