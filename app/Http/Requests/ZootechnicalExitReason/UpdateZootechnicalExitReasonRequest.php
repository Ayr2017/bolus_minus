<?php

namespace App\Http\Requests\ZootechnicalExitReason;

use Illuminate\Foundation\Http\FormRequest;

class UpdateZootechnicalExitReasonRequest extends FormRequest
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
            //TODO: для чего это
//            'restriction_reason' => [
//                'required',
//                'integer',
//                'exists:restriction_reasons,id',
//            ],
            'name' => [
                'required',
                'string',
                'max:255',
                "unique:restriction_reasons,name,{$this->zootechnicalExitReason},id",
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'is_active'=>['nullable','boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'zootechnicalExitReason' => $this->route('zootechnical_exit_reason')->id,
        ]);
    }
}
