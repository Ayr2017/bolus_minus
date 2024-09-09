<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory, HasPermissions, HasRoles;
    protected $fillable = [
        'uuid',
        'position',
        'organisation_id',
        'user_id',
    ];
    protected string $guard_name = 'web';


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function organisation():BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
