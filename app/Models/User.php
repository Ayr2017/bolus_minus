<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     * @property int $id
     * @property string $name
     * @property string $email
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'surname',
        'phone',
        'email_verified_at',
        'current_employee_id',
        'is_active',
        'lastname'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'user_id', 'id');
    }

    public function currentEmployee():BelongsTo
    {
        return $this->belongsTo(Employee::class, 'current_employee_id', 'id');
    }

    public function setCurrentEmployee(Employee $employee):bool
    {
        return $this->update([
            'current_employee_id' => $employee->id,
        ]);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name." ".$this->surname,
        );
    }
}
