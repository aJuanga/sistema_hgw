<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disease extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'description',
        'recommendations',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación: Una enfermedad pertenece a muchos perfiles de salud
    public function healthProfiles()
    {
        return $this->belongsToMany(HealthProfile::class, 'health_profile_disease')
                    ->withPivot('diagnosed_at')
                    ->withTimestamps();
    }

    // Relación: Una enfermedad tiene muchos productos contraindicados
    public function contraindicatedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_disease_contraindication')
                    ->withPivot('reason')
                    ->withTimestamps();
    }
}