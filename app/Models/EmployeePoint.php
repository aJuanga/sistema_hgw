<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeePoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'points',
        'amount',
        'type',
        'date',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    // ==========================================
    // RELACIONES
    // ==========================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ==========================================
    // MÉTODOS ESTÁTICOS
    // ==========================================

    /**
     * Obtener total de puntos de un empleado
     */
    public static function getEmployeeTotalPoints($userId)
    {
        return self::where('user_id', $userId)->sum('points');
    }

    /**
     * Obtener total en dinero de un empleado
     */
    public static function getEmployeeTotalAmount($userId)
    {
        return self::where('user_id', $userId)->sum('amount');
    }

    /**
     * Obtener puntos por día de un empleado
     */
    public static function getEmployeePointsByDay($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)
            ->select(
                'date',
                DB::raw('SUM(points) as total_points'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('COUNT(*) as total_transactions')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc');

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        return $query->get();
    }

    /**
     * Obtener puntos del día actual de un empleado
     */
    public static function getEmployeeTodayPoints($userId)
    {
        return self::where('user_id', $userId)
            ->whereDate('date', today())
            ->sum('points');
    }

    /**
     * Obtener monto del día actual de un empleado
     */
    public static function getEmployeeTodayAmount($userId)
    {
        return self::where('user_id', $userId)
            ->whereDate('date', today())
            ->sum('amount');
    }
}
