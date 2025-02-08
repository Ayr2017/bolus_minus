<?php

namespace App\Http\Requests\Animal;

use Illuminate\Foundation\Http\FormRequest;

class ShowAnimalRequest extends FormRequest
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
            // 'animal' => ['required', 'integer' ,'exists:animals,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'animal' => $this->route('animal'),
        ]);
    }
}
