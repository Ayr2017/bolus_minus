<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilkingEquipment extends Model
{
    use HasFactory;

    protected $fillable = ['is_active', 'organization_id', 'department_id', 'equipment_type', 'milking_places_amount', 'milking_per_day_amount'];

    protected $table = 'milking_equipments';

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'organization_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'department_id');
    }
}
