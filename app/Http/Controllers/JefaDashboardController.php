<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JefaDashboardController extends Controller
{
    /**
     * Display the executive dashboard for Jefa.
     */
    public function index()
    {
        // Ventas del día
        $today = Carbon::today();
        $salesToday = Order::whereDate('created_at', $today)
            ->where('status', '!=', 'cancelado')
            ->sum('total');

        // Ventas de la semana
        $startOfWeek = Carbon::now()->startOfWeek();
        $salesWeek = Order::where('created_at', '>=', $startOfWeek)
            ->where('status', '!=', 'cancelado')
            ->sum('total');

        // Ventas del mes
        $startOfMonth = Carbon::now()->startOfMonth();
        $salesMonth = Order::where('created_at', '>=', $startOfMonth)
            ->where('status', '!=', 'cancelado')
            ->sum('total');

        // Productos más vendidos
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelado')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Inventario crítico (stock bajo)
        $criticalInventory = DB::table('inventory')
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->select('products.name', 'inventory.current_stock', 'inventory.minimum_stock')
            ->whereRaw('inventory.current_stock <= inventory.minimum_stock')
            ->orderBy('inventory.current_stock', 'asc')
            ->take(10)
            ->get();

        // Desempeño de empleados (pedidos procesados)
        $employeePerformance = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->where('roles.slug', 'empleado')
            ->where('orders.created_at', '>=', $startOfMonth)
            ->select(
                'users.name',
                DB::raw('COUNT(orders.id) as orders_processed'),
                DB::raw('SUM(orders.total) as total_sales')
            )
            ->groupBy('users.id', 'users.name')
            ->orderBy('orders_processed', 'desc')
            ->take(5)
            ->get();

        // Estadísticas generales
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::whereIn('status', ['pendiente', 'en_preparacion'])->count(),
            'completed_orders_month' => Order::where('status', 'completado')
                ->where('created_at', '>=', $startOfMonth)
                ->count(),
            'total_customers' => DB::table('users')
                ->join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.slug', 'cliente')
                ->count(),
            'low_stock_count' => DB::table('inventory')
                ->whereRaw('current_stock <= minimum_stock')
                ->count(),
        ];

        // Pedidos recientes
        $recentOrders = Order::with('user')
            ->latest()
            ->take(8)
            ->get();

        // Ventas por día de la última semana (para gráfico)
        $salesByDay = Order::where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('status', '!=', 'cancelado')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('jefa.dashboard', compact(
            'salesToday',
            'salesWeek',
            'salesMonth',
            'topProducts',
            'criticalInventory',
            'employeePerformance',
            'stats',
            'recentOrders',
            'salesByDay'
        ));
    }
}
