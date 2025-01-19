<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreedingBull extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'semen_supplier',
        'nickname',
        'date_of_birth',
        'country_of_birth',
        'tag_number',
        'semen_code',
        'rshn_id',
        'coat_color_id',
        'breed_id',
        'is_selected',
        'is_active',
        'is_own'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_own' => 'boolean',
        'is_selected' => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function selected()
    {
        return $this->where('is_selected', true);
    }

    public function coatColor(): BelongsTo
    {
        return $this->belongsTo(CoatColor::class, 'coat_color_id', 'id');
    }
}
