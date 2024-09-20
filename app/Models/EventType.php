<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventType extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
        'slug',
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class)->orderBy('order');
    }


}
