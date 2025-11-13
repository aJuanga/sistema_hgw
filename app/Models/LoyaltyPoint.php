<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'points',
        'type',
        'description',
    ];

    protected $casts = [
        'points' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function getUserTotalPoints($userId)
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('loyalty_points')) {
                return 0;
            }
            
            $earned = self::where('user_id', $userId)
                ->where('type', 'earned')
                ->sum('points') ?? 0;
            
            $redeemed = self::where('user_id', $userId)
                ->where('type', 'redeemed')
                ->sum('points') ?? 0;
            
            return max(0, $earned - $redeemed);
        } catch (\Exception $e) {
            return 0;
        }
    }
}

