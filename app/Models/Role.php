<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación: Un rol tiene muchos usuarios
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    // Relación: Un rol tiene muchos permisos
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}