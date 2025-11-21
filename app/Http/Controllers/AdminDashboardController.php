<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Resumen de inventario
        $inventorySummary = DB::table('inventory')
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->select(
                DB::raw('COUNT(*) as total_items'),
                DB::raw('SUM(current_stock) as total_stock'),
                DB::raw('SUM(CASE WHEN current_stock <= minimum_stock THEN 1 ELSE 0 END) as low_stock_count'),
                DB::raw('SUM(CASE WHEN current_stock = 0 THEN 1 ELSE 0 END) as out_of_stock_count')
            )
            ->first();

        // Pedidos pendientes (pendiente + en_preparacion)
        $pendingOrdersCount = Order::whereIn('status', ['pendiente', 'en_preparacion'])->count();

        // Últimos pedidos pendientes
        $recentPendingOrders = Order::with('user')
            ->whereIn('status', ['pendiente', 'en_preparacion'])
            ->latest()
            ->take(5)
            ->get();

        // Productos con stock bajo
        $lowStockProducts = DB::table('inventory')
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->select('products.name', 'inventory.current_stock', 'inventory.minimum_stock')
            ->whereRaw('inventory.current_stock <= inventory.minimum_stock')
            ->orderBy('inventory.current_stock', 'asc')
            ->take(8)
            ->get();

        // Actividad reciente de inventario
        $recentInventoryActivity = DB::table('inventory')
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->select('products.name', 'inventory.current_stock', 'inventory.updated_at')
            ->orderBy('inventory.updated_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'inventorySummary',
            'pendingOrdersCount',
            'recentPendingOrders',
            'lowStockProducts',
            'recentInventoryActivity'
        ));
    }
}
