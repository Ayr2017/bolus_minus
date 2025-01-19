<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class TagColor extends Model
{
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->validateHex();
        });
    }

    /**
     * Проверяет, что поле hex имеет правильный формат.
     *
     * @throws ValidationException
     */
    public function validateHex()
    {
        $value = strtolower(trim($this->hex));

        // Проверяем, соответствует ли значение формату HEX (с символом #)
        if (!preg_match('/^#[0-9a-f]{6}$/', $value)) {
            throw ValidationException::withMessages([
                'hex' => "Значение '{$this->hex}' должно быть в формате HEX (например, #FFFFFF).",
            ]);
        }

        $this->hex = $value;
    }
}
