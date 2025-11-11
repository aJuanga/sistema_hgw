<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'date_of_birth',
        'preferences',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    // Relación: Un cliente pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un cliente tiene un perfil de salud
    public function healthProfile()
    {
        return $this->hasOne(HealthProfile::class);
    }

    // Relación: Un cliente tiene muchos pedidos
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }

    // Relación: Un cliente tiene muchas notificaciones
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
    }
}