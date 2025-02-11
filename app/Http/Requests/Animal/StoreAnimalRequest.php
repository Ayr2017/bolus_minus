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
            'name' => 'required|string|unique:animals,name',
            'number' => 'required|string|unique:animals,number',
            'organisation_id' => 'required|exists:organisations,id',
            'birthday' => 'required|date',
            'breed_id' => 'required|exists:breeds,id',
            'number_rshn' => 'nullable|string|unique:animals,number_rshn',
            'bolus_id' => 'nullable|integer|exists:boluses,id',
            'number_rf' => 'nullable|string|unique:animals,number_rf',
            'number_tavro' => 'nullable|string|unique:animals,number_tavro',
            'number_tag' => 'nullable|string|unique:animals,number_tag',
            'tag_color' => 'nullable|string',
            'group_id' => 'nullable|integer|exists:animal_groups,id',
            'entry_id'=> 'nullable|integer|exists:animal_entries,id',
            'number_collar' => 'nullable|string',
            'status_id' => 'sometimes|integer|exists:statuses,id',
            'sex' => 'required|in:male,female',
            'withdrawn_at' => 'nullable|date|after_or_equal:birthday',


            // TODO: добавить (для соответствия с фронтом):
            // -------обязательные-------
            // возрастная группа
            // -------необязательные-------
            // отделение (department_id)
            // хозяйство производитель инн
            // хозяйство продавец инн
            // мать
            // отец
            // вес
            // дата поступления
            // дата ввода в стадо
            // основание ввода в стадо (herd_entry_reason_id)

        ];
    }
}
