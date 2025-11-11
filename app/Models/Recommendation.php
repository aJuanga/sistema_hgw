<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'compatibility_score',
        'recommendation_type',
        'explanation',
        'genetic_algorithm_data',
    ];

    protected $casts = [
        'compatibility_score' => 'decimal:2',
        'genetic_algorithm_data' => 'array',
    ];

    // Relación: Una recomendación pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Una recomendación pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación: Una recomendación tiene muchos logs
    public function logs()
    {
        return $this->hasMany(RecommendationLog::class);
    }
}