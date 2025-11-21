<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\EmployeePoint;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display the reports index page
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Generate inventory report
     */
    public function inventory(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Productos con stock actual
        $products = Product::with('category')
            ->leftJoin('inventory', 'products.id', '=', 'inventory.product_id')
            ->select(
                'products.*',
                'inventory.current_stock',
                'inventory.minimum_stock',
                'inventory.maximum_stock'
            )
            ->get();

        // Calcular productos vendidos en el período
        $soldProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereIn('orders.status', ['completado', 'entregado'])
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('order_items.product_id')
            ->pluck('total_sold', 'product_id');

        // Alertas de productos a reponer
        $lowStockProducts = $products->filter(function ($product) {
            return $product->current_stock <= $product->minimum_stock;
        });

        // Productos con alto stock (más del 80% del máximo)
        $highStockProducts = $products->filter(function ($product) {
            return $product->current_stock >= ($product->maximum_stock * 0.8);
        });

        // Productos con stock medio
        $mediumStockProducts = $products->filter(function ($product) {
            return $product->current_stock > $product->minimum_stock
                && $product->current_stock < ($product->maximum_stock * 0.8);
        });

        // Productos por categoría
        $productsByCategory = $products->groupBy('category.name')->map(function ($items) {
            return [
                'count' => $items->count(),
                'stock' => $items->sum('current_stock'),
                'value' => $items->sum(function ($item) {
                    return $item->current_stock * $item->price;
                })
            ];
        });

        // Movimientos de inventario recientes
        $recentMovements = DB::table('inventory_movements')
            ->join('products', 'inventory_movements.product_id', '=', 'products.id')
            ->whereBetween('inventory_movements.created_at', [$startDate, $endDate])
            ->select(
                'products.name',
                'inventory_movements.type',
                'inventory_movements.quantity',
                'inventory_movements.reason',
                'inventory_movements.created_at'
            )
            ->orderBy('inventory_movements.created_at', 'desc')
            ->limit(20)
            ->get();

        // Estadísticas generales
        $stats = [
            'total_products' => $products->count(),
            'low_stock_count' => $lowStockProducts->count(),
            'medium_stock_count' => $mediumStockProducts->count(),
            'high_stock_count' => $highStockProducts->count(),
            'total_stock_value' => $products->sum(function ($product) {
                return $product->current_stock * $product->price;
            }),
            'out_of_stock' => $products->filter(function ($product) {
                return $product->current_stock == 0;
            })->count(),
            'average_stock_per_product' => $products->avg('current_stock'),
            'total_units_in_stock' => $products->sum('current_stock'),
            'categories_count' => $productsByCategory->count(),
        ];

        return view('reports.inventory', compact(
            'products',
            'soldProducts',
            'lowStockProducts',
            'highStockProducts',
            'mediumStockProducts',
            'productsByCategory',
            'recentMovements',
            'stats',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Generate sales report
     */
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $period = $request->input('period', 'day'); // day, week, month

        // Ventas por período
        $salesByPeriod = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total) as total_sales')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Productos más vendidos
        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereIn('orders.status', ['completado', 'entregado'])
            ->select(
                'products.name',
                'products.price',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        // Ventas por categoría
        $salesByCategory = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereIn('orders.status', ['completado', 'entregado'])
            ->select(
                'categories.name as category_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as orders_count')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Pedidos cancelados
        $cancelledOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'cancelado')
            ->count();

        // Tasa de conversión
        $totalOrdersAll = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        // Comparativa con período anterior
        $daysDiff = Carbon::parse($endDate)->diffInDays(Carbon::parse($startDate)) + 1;
        $previousStartDate = Carbon::parse($startDate)->subDays($daysDiff)->format('Y-m-d');
        $previousEndDate = Carbon::parse($startDate)->subDay()->format('Y-m-d');

        $previousSales = Order::whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->sum('total');

        $previousOrders = Order::whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->count();

        // Método de pago más usado
        $topPaymentMethod = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->select('payment_method_id', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method_id')
            ->orderBy('count', 'desc')
            ->first();

        // Estadísticas generales
        $totalSales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->sum('total');

        $stats = [
            'total_sales' => $totalSales,
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->count(),
            'average_order_value' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->avg('total'),
            'pending_orders' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['pendiente', 'en_preparacion'])
                ->count(),
            'cancelled_orders' => $cancelledOrders,
            'completion_rate' => $totalOrdersAll > 0 ? round((($totalOrdersAll - $cancelledOrders) / $totalOrdersAll) * 100, 2) : 0,
            'previous_sales' => $previousSales,
            'previous_orders' => $previousOrders,
            'sales_growth' => $previousSales > 0 ? round((($totalSales - $previousSales) / $previousSales) * 100, 2) : 0,
            'top_payment_method' => $topPaymentMethod->payment_method_id ?? 'N/A',
            'items_sold' => OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->whereIn('orders.status', ['completado', 'entregado'])
                ->sum('order_items.quantity'),
        ];

        return view('reports.sales', compact(
            'salesByPeriod',
            'topProducts',
            'salesByCategory',
            'stats',
            'startDate',
            'endDate',
            'period'
        ));
    }

    /**
     * Generate employees report
     */
    public function employees(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Empleados con sus estadísticas
        $employees = User::whereHas('roles', function ($query) {
            $query->where('name', 'empleado');
        })
        ->with(['roles'])
        ->get();

        $employeeStats = [];
        foreach ($employees as $employee) {
            // Pedidos realizados por el empleado
            $ordersCount = Order::where('user_id', $employee->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            // Puntos generados
            $points = EmployeePoint::where('user_id', $employee->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('points');

            // Pedidos completados
            $completedOrders = Order::where('user_id', $employee->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->count();

            $employeeStats[] = [
                'employee' => $employee,
                'orders_count' => $ordersCount,
                'completed_orders' => $completedOrders,
                'points' => $points,
                'completion_rate' => $ordersCount > 0 ? round(($completedOrders / $ordersCount) * 100, 2) : 0,
            ];
        }

        // Ordenar por puntos
        usort($employeeStats, function ($a, $b) {
            return $b['points'] <=> $a['points'];
        });

        // Empleado del mes (más puntos)
        $employeeOfMonth = !empty($employeeStats) ? $employeeStats[0] : null;

        // Empleado con mejor tasa de completación
        $bestCompletion = collect($employeeStats)->sortByDesc('completion_rate')->first();

        // Distribución de puntos
        $pointsDistribution = [
            'high' => collect($employeeStats)->filter(fn($e) => $e['points'] >= 100)->count(),
            'medium' => collect($employeeStats)->filter(fn($e) => $e['points'] >= 50 && $e['points'] < 100)->count(),
            'low' => collect($employeeStats)->filter(fn($e) => $e['points'] < 50)->count(),
        ];

        // Total de ventas generadas por empleados
        $totalSalesByEmployees = Order::whereIn('user_id', $employees->pluck('id'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->sum('total');

        // Estadísticas generales
        $stats = [
            'total_employees' => count($employeeStats),
            'total_points' => array_sum(array_column($employeeStats, 'points')),
            'total_orders' => array_sum(array_column($employeeStats, 'orders_count')),
            'total_completed_orders' => array_sum(array_column($employeeStats, 'completed_orders')),
            'average_points' => count($employeeStats) > 0 ? array_sum(array_column($employeeStats, 'points')) / count($employeeStats) : 0,
            'average_completion_rate' => count($employeeStats) > 0 ? array_sum(array_column($employeeStats, 'completion_rate')) / count($employeeStats) : 0,
            'total_sales' => $totalSalesByEmployees,
            'average_sales_per_employee' => count($employeeStats) > 0 ? $totalSalesByEmployees / count($employeeStats) : 0,
            'employee_of_month' => $employeeOfMonth,
            'best_completion' => $bestCompletion,
        ];

        return view('reports.employees', compact(
            'employeeStats',
            'pointsDistribution',
            'stats',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Generate financial report
     */
    public function financial(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Ingresos totales
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->sum('total');

        // Ventas por método de pago
        $paymentMethods = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->select('payment_method_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method_id')
            ->get();

        // Ingresos por día
        $dailyRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Comparativa con período anterior
        $previousStartDate = Carbon::parse($startDate)->subDays(
            Carbon::parse($endDate)->diffInDays(Carbon::parse($startDate))
        )->format('Y-m-d');
        $previousEndDate = $startDate;

        $previousRevenue = Order::whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->sum('total');

        $revenueGrowth = $previousRevenue > 0
            ? round((($totalRevenue - $previousRevenue) / $previousRevenue) * 100, 2)
            : 0;

        // Día con más ventas
        $bestDay = $dailyRevenue->sortByDesc('revenue')->first();

        // Día con menos ventas
        $worstDay = $dailyRevenue->sortBy('revenue')->first();

        // Promedio de pedidos por día
        $avgOrdersPerDay = $dailyRevenue->avg('orders') ?? 0;

        // Ticket promedio por método de pago
        $avgTicketByPayment = $paymentMethods->map(function($pm) {
            return [
                'method' => $pm->payment_method_id,
                'avg_ticket' => $pm->count > 0 ? $pm->total / $pm->count : 0
            ];
        });

        // Proyección mensual (si el período es menor a un mes)
        $daysCovered = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
        $monthlyProjection = $daysCovered > 0 ? ($totalRevenue / $daysCovered) * 30 : 0;

        // Ventas por tipo de delivery
        $salesByDelivery = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->select('delivery_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('delivery_type')
            ->get();

        // Estadísticas generales
        $stats = [
            'total_revenue' => $totalRevenue,
            'previous_revenue' => $previousRevenue,
            'revenue_growth' => $revenueGrowth,
            'average_daily_revenue' => $dailyRevenue->avg('revenue') ?? 0,
            'best_day_revenue' => $bestDay->revenue ?? 0,
            'best_day_date' => $bestDay->date ?? 'N/A',
            'worst_day_revenue' => $worstDay->revenue ?? 0,
            'worst_day_date' => $worstDay->date ?? 'N/A',
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->count(),
            'avg_orders_per_day' => $avgOrdersPerDay,
            'monthly_projection' => $monthlyProjection,
            'payment_methods_count' => $paymentMethods->count(),
            'most_used_payment' => $paymentMethods->sortByDesc('count')->first()->payment_method_id ?? 'N/A',
        ];

        return view('reports.financial', compact(
            'paymentMethods',
            'dailyRevenue',
            'salesByDelivery',
            'avgTicketByPayment',
            'stats',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Generate PDF for inventory report
     */
    public function inventoryPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $products = Product::with('category')
            ->leftJoin('inventory', 'products.id', '=', 'inventory.product_id')
            ->select(
                'products.*',
                'inventory.current_stock',
                'inventory.minimum_stock',
                'inventory.maximum_stock'
            )
            ->get();

        $soldProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereIn('orders.status', ['completado', 'entregado'])
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('order_items.product_id')
            ->pluck('total_sold', 'product_id');

        $lowStockProducts = $products->filter(function ($product) {
            return $product->current_stock <= $product->minimum_stock;
        });

        $stats = [
            'total_products' => $products->count(),
            'low_stock_count' => $lowStockProducts->count(),
            'total_stock_value' => $products->sum(function ($product) {
                return $product->current_stock * $product->price;
            }),
            'out_of_stock' => $products->filter(function ($product) {
                return $product->current_stock == 0;
            })->count(),
        ];

        $pdf = Pdf::loadView('reports.pdf.inventory', compact('products', 'soldProducts', 'lowStockProducts', 'stats', 'startDate', 'endDate'));
        return $pdf->download('reporte-inventario-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF for sales report
     */
    public function salesPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $salesByPeriod = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total) as total_sales')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereIn('orders.status', ['completado', 'entregado'])
            ->select(
                'products.name',
                'products.price',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        $stats = [
            'total_sales' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->sum('total'),
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->count(),
            'average_order_value' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->avg('total'),
        ];

        $pdf = Pdf::loadView('reports.pdf.sales', compact('salesByPeriod', 'topProducts', 'stats', 'startDate', 'endDate'));
        return $pdf->download('reporte-ventas-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF for employees report
     */
    public function employeesPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $employees = User::whereHas('roles', function ($query) {
            $query->where('name', 'empleado');
        })
        ->with(['roles'])
        ->get();

        $employeeStats = [];
        foreach ($employees as $employee) {
            $ordersCount = Order::where('user_id', $employee->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $points = EmployeePoint::where('user_id', $employee->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('points');

            $completedOrders = Order::where('user_id', $employee->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->count();

            $employeeStats[] = [
                'employee' => $employee,
                'orders_count' => $ordersCount,
                'completed_orders' => $completedOrders,
                'points' => $points,
                'completion_rate' => $ordersCount > 0 ? round(($completedOrders / $ordersCount) * 100, 2) : 0,
            ];
        }

        usort($employeeStats, function ($a, $b) {
            return $b['points'] <=> $a['points'];
        });

        $stats = [
            'total_employees' => count($employeeStats),
            'total_points' => array_sum(array_column($employeeStats, 'points')),
            'total_orders' => array_sum(array_column($employeeStats, 'orders_count')),
            'average_points' => count($employeeStats) > 0 ? array_sum(array_column($employeeStats, 'points')) / count($employeeStats) : 0,
        ];

        $pdf = Pdf::loadView('reports.pdf.employees', compact('employeeStats', 'stats', 'startDate', 'endDate'));
        return $pdf->download('reporte-empleados-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF for financial report
     */
    public function financialPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->sum('total');

        $paymentMethods = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->select('payment_method_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method_id')
            ->get();

        $dailyRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $previousStartDate = Carbon::parse($startDate)->subDays(
            Carbon::parse($endDate)->diffInDays(Carbon::parse($startDate))
        )->format('Y-m-d');
        $previousEndDate = $startDate;

        $previousRevenue = Order::whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->whereIn('status', ['completado', 'entregado'])
            ->sum('total');

        $revenueGrowth = $previousRevenue > 0
            ? round((($totalRevenue - $previousRevenue) / $previousRevenue) * 100, 2)
            : 0;

        $stats = [
            'total_revenue' => $totalRevenue,
            'previous_revenue' => $previousRevenue,
            'revenue_growth' => $revenueGrowth,
            'average_daily_revenue' => $dailyRevenue->avg('revenue') ?? 0,
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->count(),
        ];

        $pdf = Pdf::loadView('reports.pdf.financial', compact('paymentMethods', 'dailyRevenue', 'stats', 'startDate', 'endDate'));
        return $pdf->download('reporte-financiero-' . date('Y-m-d') . '.pdf');
    }
}
