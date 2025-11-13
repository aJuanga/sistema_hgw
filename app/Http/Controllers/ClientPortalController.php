<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\LoyaltyPoint;
use App\Models\Category;
use App\Models\CafeRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientPortalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        // Obtener estadísticas del usuario
        $stats = $this->getUserStats($user);

        // Productos con paginación
        $products = Product::with('category')
            ->where('is_available', true)
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(12);

        // Productos destacados (más vendidos o nuevos)
        $featuredProducts = Product::with('category')
            ->where('is_available', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        // Categorías
        $categories = Category::withCount('products')->get();

        // Pedidos recientes
        $recentOrders = Order::with(['orderItems.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Estadísticas de calificaciones de la cafetería
        $cafeRatingStats = [
            'average' => round(CafeRating::getAverageRating(), 1),
            'total' => CafeRating::getTotalRatings(),
        ];

        return view('client.dashboard', compact(
            'products',
            'search',
            'stats',
            'featuredProducts',
            'categories',
            'recentOrders',
            'cafeRatingStats'
        ));
    }

    private function getUserStats($user)
    {
        $totalOrders = Order::where('user_id', $user->id)->count();

        $totalSpent = Order::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'delivered'])
            ->sum('total') ?? 0;

        $loyaltyPoints = LoyaltyPoint::getUserTotalPoints($user->id);

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
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
        ];
    }
}

