<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recommendation_id',
        'action',
        'user_purchased',
    ];

    protected $casts = [
        'user_purchased' => 'boolean',
    ];

    // Relación: Un log pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un log pertenece a una recomendación
    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }
}