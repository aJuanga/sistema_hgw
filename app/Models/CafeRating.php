<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CafeRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Relación: Una calificación pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el promedio de calificaciones de la cafetería
     */
    public static function getAverageRating()
    {
        return self::avg('rating') ?? 0;
    }

    /**
     * Obtener el total de calificaciones
     */
    public static function getTotalRatings()
    {
        return self::count();
    }

    /**
     * Obtener las últimas calificaciones
     */
    public static function getRecentRatings($limit = 10)
    {
        return self::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Verificar si un usuario ya calificó
     */
    public static function userHasRated($userId)
    {
        return self::where('user_id', $userId)->exists();
    }
}
