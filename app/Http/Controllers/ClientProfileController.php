<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientProfileController extends Controller
{
    /**
     * Mostrar el perfil del cliente
     */
    public function show()
    {
        $user = Auth::user();

        // Obtener estadísticas del usuario
        $stats = $this->getUserStats($user);

        // Pedidos recientes
        $recentOrders = Order::with(['orderItems.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('client.profile', compact('stats', 'recentOrders'));
    }

    /**
     * Obtener estadísticas del usuario
     */
    private function getUserStats($user)
    {
        $totalOrders = Order::where('user_id', $user->id)->count();

        $totalSpent = Order::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'delivered'])
            ->sum('total') ?? 0;

        $loyaltyPoints = LoyaltyPoint::getUserTotalPoints($user->id);

        // Puntos ganados este mes
        $pointsThisMonth = DB::table('loyalty_points')
            ->where('user_id', $user->id)
            ->where('type', 'earned')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('points') ?? 0;

        // Puntos canjeados
        $pointsRedeemed = DB::table('loyalty_points')
            ->where('user_id', $user->id)
            ->where('type', 'redeemed')
            ->sum('points') ?? 0;

        $pendingOrders = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing', 'ready'])
            ->count();

        $completedOrders = Order::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'delivered'])
            ->count();

        return [
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
            'loyaltyPoints' => $loyaltyPoints,
            'pointsThisMonth' => $pointsThisMonth,
            'pointsRedeemed' => abs($pointsRedeemed), // Convertir a positivo para mostrar
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
        ];
    }
}
