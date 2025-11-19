<?php

namespace App\Http\Controllers;

use App\Models\EmployeePoint;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    /**
     * Mostrar el dashboard del empleado
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Verificar que sea empleado
        if (!$user->isEmpleado()) {
            abort(403, 'Acceso no autorizado');
        }

        // Obtener fechas de filtro (por defecto el mes actual)
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Pedidos creados por el empleado
        $orders = Order::where('user_id', $user->id)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Puntos del empleado
        $totalPoints = EmployeePoint::getEmployeeTotalPoints($user->id);
        $totalAmount = EmployeePoint::getEmployeeTotalAmount($user->id);
        $todayPoints = EmployeePoint::getEmployeeTodayPoints($user->id);
        $todayAmount = EmployeePoint::getEmployeeTodayAmount($user->id);

        // Puntos por día en el rango seleccionado
        $pointsByDay = EmployeePoint::getEmployeePointsByDay($user->id, $startDate, $endDate);

        // Estadísticas adicionales
        $totalOrdersCount = Order::where('user_id', $user->id)->count();
        $completedOrdersCount = Order::where('user_id', $user->id)
            ->where('status', 'entregado')
            ->count();

        return view('employee.dashboard', compact(
            'orders',
            'totalPoints',
            'totalAmount',
            'todayPoints',
            'todayAmount',
            'pointsByDay',
            'totalOrdersCount',
            'completedOrdersCount',
            'startDate',
            'endDate'
        ));
    }
}
