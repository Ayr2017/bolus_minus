<?php

namespace App\Http\Requests\Animal;

use App\Models\Animal;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalRequest extends FormRequest
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
            'name' => 'nullable|string',
            'number' => 'nullable|string|unique:animals,number,'.$this->animal->id,
            'organisation_id' => 'nullable|exists:organisations,id',
            'birthday' => 'nullable|date',
            'breed_id' => 'nullable|exists:breeds,id',
            'number_rshn' => 'nullable|string|unique:animals,number_rshn,'.$this->animal->id,
            'bolus_id' => 'nullable|exists:boluses,id',
            'number_rf'=>'nullable|string|unique:animals,number_rf,'.$this->animal->id,
            'number_tavro' => 'nullable|string|unique:animals,number_tavro,'.$this->animal->id,
            'number_tag'=>'nullable|string|unique:animals,number_tag,'.$this->animal->id,
            'tag_color' => 'nullable|string',
            'number_collar'=>'nullable|string',
            'status_id' => 'nullable|integer|exists:statuses,id',
            'sex'=>'nullable|in:male,female',
            'withdrawn_at'=>'nullable|date',
            'is_active'=>'nullable|boolean',
        ];
    }
}
