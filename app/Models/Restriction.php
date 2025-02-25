<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restriction extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'is_active',
        "description",
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
