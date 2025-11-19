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

        // Estadísticas generales
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

        return view('reports.inventory', compact('products', 'soldProducts', 'lowStockProducts', 'stats', 'startDate', 'endDate'));
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
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        // Estadísticas generales
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
            'pending_orders' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['pendiente', 'en_preparacion'])
                ->count(),
        ];

        return view('reports.sales', compact('salesByPeriod', 'topProducts', 'stats', 'startDate', 'endDate', 'period'));
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

        // Estadísticas generales
        $stats = [
            'total_employees' => count($employeeStats),
            'total_points' => array_sum(array_column($employeeStats, 'points')),
            'total_orders' => array_sum(array_column($employeeStats, 'orders_count')),
            'average_points' => count($employeeStats) > 0 ? array_sum(array_column($employeeStats, 'points')) / count($employeeStats) : 0,
        ];

        return view('reports.employees', compact('employeeStats', 'stats', 'startDate', 'endDate'));
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
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method')
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

        // Estadísticas generales
        $stats = [
            'total_revenue' => $totalRevenue,
            'previous_revenue' => $previousRevenue,
            'revenue_growth' => $revenueGrowth,
            'average_daily_revenue' => $dailyRevenue->avg('revenue') ?? 0,
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['completado', 'entregado'])
                ->count(),
        ];

        return view('reports.financial', compact('paymentMethods', 'dailyRevenue', 'stats', 'startDate', 'endDate'));
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
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
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
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method')
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
