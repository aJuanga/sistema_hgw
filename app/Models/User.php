<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'phone',
        'allergies',
        'profile_photo',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // ==========================================
    // JWT METHODS
    // ==========================================
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // ==========================================
    // RELACIONES
    // ==========================================
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function healthProfile()
    {
        return $this->hasOne(HealthProfile::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    // ==========================================
    // MÉTODOS DE ROLES Y PERMISOS
    // ==========================================
    
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role) || $this->roles->contains('name', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermission($permissionName)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permissionName) {
            $query->where('name', $permissionName);
        })->exists();
    }

    public function isJefa()
    {
        return $this->hasRole('jefa') || $this->hasRole('Jefa');
    }

    public function isAdmin()
    {
        return $this->hasRole('administrador') || $this->hasRole('Administrador');
    }

    public function isEmpleado()
    {
        return $this->hasRole('empleado') || $this->hasRole('Empleado');
    }

    public function isCliente()
    {
        return $this->hasRole('cliente') || $this->hasRole('Cliente');
    }

    // ✅ ELIMINADO: método can() que causaba conflicto
    // Usa hasPermission() directamente

    public function getRoleNames()
    {
        return $this->roles->pluck('name')->toArray();
    }

    public function getMainRole()
    {
        return $this->roles->first();
    }

    public function getMainRoleName()
    {
        $role = $this->roles->first();
        return $role ? $role->name : 'Sin rol';
    }
}