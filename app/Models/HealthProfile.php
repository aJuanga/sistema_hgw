<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'user_id',
        'age',
        'weight',
        'height',
        'bmi',
        'blood_type',
        'health_goal',
        'medications',
        'notes',
        'additional_notes',
    ];

    protected $casts = [
        'age' => 'integer',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'bmi' => 'decimal:2',
    ];

    // Relación: Un perfil de salud pertenece a un cliente
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relación: Un perfil de salud pertenece a un usuario (legacy)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un perfil de salud tiene muchas enfermedades
    public function diseases()
    {
        return $this->belongsToMany(Disease::class, 'health_profile_disease')
                    ->withPivot('diagnosed_at')
                    ->withTimestamps();
    }

    // Relación: Un perfil de salud tiene muchas alergias
    public function allergies()
    {
        return $this->belongsToMany(Allergy::class, 'health_profile_allergy')
                    ->withPivot('reaction_description')
                    ->withTimestamps();
    }

    // Método helper: Calcular BMI automáticamente
    public static function calculateBMI($weight, $height)
    {
        if ($height > 0) {
            return round($weight / ($height * $height), 2);
        }
        return null;
    }
}