<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;
use App\Enums\EquipmentType;

class MilkingEquipment extends Model
{
    use HasFactory;

    protected $fillable = ['is_active', 'organization_id', 'department_id', 'equipment_type', 'milking_places_amount', 'milking_per_day_amount'];

    protected $table = 'milking_equipments';

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $validator = validator($model->attributesToArray(), [
                'milking_places_amount' => 'required|integer',
                'equipment_type' => 'required|in:' . implode(',', array_column(EquipmentType::cases(), 'value')),
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'organization_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'department_id');
    }
}
