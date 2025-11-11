<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allergy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'severity',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación: Una alergia pertenece a muchos perfiles de salud
    public function healthProfiles()
    {
        return $this->belongsToMany(HealthProfile::class, 'health_profile_allergy')
                    ->withPivot('reaction_description')
                    ->withTimestamps();
    }
}