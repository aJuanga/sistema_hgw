<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Reporte de Ventas
     */
    public function sales(Request $request)
    {
        // Obtener filtros de fecha
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Estadísticas generales del período
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled');

        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total');
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Pedidos por día
        $ordersByDay = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total) as revenue')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Pedidos por estado
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count, SUM(total) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->get();

        // Ingresos por método de pago
        $revenueByPayment = Order::selectRaw('payment_method_id, COUNT(*) as count, SUM(total) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->groupBy('payment_method_id')
            ->get();

        return view('reports.sales', compact(
            'startDate',
            'endDate',
            'totalOrders',
            'totalRevenue',
            'averageOrderValue',
            'ordersByDay',
            'ordersByStatus',
            'revenueByPayment'
        ));
    }

    /**
     * Reporte de Productos Más Vendidos
     */
    public function products(Request $request)
    {
        // Obtener filtros
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $limit = $request->input('limit', 20);

        // Productos más vendidos
        $topProducts = OrderItem::select(
                'products.id',
                'products.name',
                'products.price',
                'categories.name as category_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as order_count')
            )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy('products.id', 'products.name', 'products.price', 'categories.name')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();

        // Productos por categoría
        $productsByCategory = OrderItem::select(
                'categories.name as category',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Productos con bajo stock
        $lowStockProducts = Product::where('stock', '<=', DB::raw('stock_min'))
            ->where('is_available', true)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        return view('reports.products', compact(
            'startDate',
            'endDate',
            'topProducts',
            'productsByCategory',
            'lowStockProducts'
        ));
    }

    /**
     * Reporte de Clientes
     */
    public function customers(Request $request)
    {
        // Obtener filtros
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $limit = $request->input('limit', 20);

        // Top clientes por gasto
        $topCustomers = User::select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total) as total_spent'),
                DB::raw('AVG(orders.total) as avg_order_value'),
                DB::raw('MAX(orders.created_at) as last_order_date')
            )
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->limit($limit)
            ->get();

        // Nuevos clientes registrados
        $newCustomers = User::whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('roles', function($query) {
                $query->where('slug', 'cliente');
            })
            ->count();

        // Clientes activos (que han hecho al menos un pedido)
        $activeCustomers = User::whereHas('orders', function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                      ->where('status', '!=', 'cancelled');
            })
            ->count();

        // Distribución de clientes por frecuencia de compra
        $customersByFrequency = User::select(
                DB::raw('CASE
                    WHEN order_count >= 10 THEN "Muy frecuente (10+)"
                    WHEN order_count >= 5 THEN "Frecuente (5-9)"
                    WHEN order_count >= 2 THEN "Ocasional (2-4)"
                    ELSE "Una vez (1)"
                END as frequency'),
                DB::raw('COUNT(*) as customer_count')
            )
            ->joinSub(
                Order::select('user_id', DB::raw('COUNT(*) as order_count'))
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', '!=', 'cancelled')
                    ->groupBy('user_id'),
                'order_stats',
                'users.id',
                '=',
                'order_stats.user_id'
            )
            ->groupBy('frequency')
            ->get();

        return view('reports.customers', compact(
            'startDate',
            'endDate',
            'topCustomers',
            'newCustomers',
            'activeCustomers',
            'customersByFrequency'
        ));
    }
}
