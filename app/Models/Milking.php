<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Milking extends Model
{
    use HasFactory;

    protected $fillable = ['is_active', 'organization_id', 'department_id', 'shift_id', 'start_time', 'end_time'];

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

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
