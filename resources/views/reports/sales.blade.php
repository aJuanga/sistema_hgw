<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-slate-900">Reporte de Ventas</h2>
                <p class="text-sm text-slate-600 mt-1">Análisis de ingresos y pedidos</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-sm font-medium rounded transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filtros de Fecha -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('reports.sales') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label for="start_date" class="block text-sm font-semibold text-slate-700 mb-2">Fecha Inicio</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                               class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label for="end_date" class="block text-sm font-semibold text-slate-700 mb-2">Fecha Fin</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                               class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                    </div>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filtrar
                    </button>
                </form>
            </div>

            <!-- Estadísticas Principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Ingresos -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">Bs. {{ number_format($totalRevenue, 2) }}</p>
                    <p class="text-sm font-medium text-slate-600">Ingresos Totales</p>
                </div>

                <!-- Total Pedidos -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl border border-amber-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">{{ $totalOrders }}</p>
                    <p class="text-sm font-medium text-slate-600">Pedidos Totales</p>
                </div>

                <!-- Valor Promedio -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">Bs. {{ number_format($averageOrderValue, 2) }}</p>
                    <p class="text-sm font-medium text-slate-600">Ticket Promedio</p>
                </div>
            </div>

            <!-- Gráfico de Pedidos por Día -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Ventas Diarias</h3>
                </div>
                <div class="p-6">
                    @if($ordersByDay->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Fecha</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Pedidos</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Ingresos</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Promedio</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($ordersByDay as $day)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                                {{ \Carbon\Carbon::parse($day->date)->locale('es')->isoFormat('D MMM YYYY') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-700">{{ $day->count }}</td>
                                            <td class="px-6 py-4 text-sm font-semibold text-green-700">Bs. {{ number_format($day->revenue, 2) }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700">Bs. {{ number_format($day->revenue / $day->count, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-slate-600 py-8">No hay datos para el período seleccionado</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pedidos por Estado -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Pedidos por Estado</h3>
                    </div>
                    <div class="p-6">
                        @if($ordersByStatus->count() > 0)
                            <div class="space-y-3">
                                @foreach($ordersByStatus as $status)
                                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ ucfirst(str_replace('_', ' ', $status->status)) }}</p>
                                            <p class="text-sm text-slate-600">{{ $status->count }} pedidos</p>
                                        </div>
                                        <span class="text-lg font-bold text-amber-700">Bs. {{ number_format($status->total, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-slate-600 py-8">No hay datos</p>
                        @endif
                    </div>
                </div>

                <!-- Ingresos por Método de Pago -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Métodos de Pago</h3>
                    </div>
                    <div class="p-6">
                        @if($revenueByPayment->count() > 0)
                            <div class="space-y-3">
                                @foreach($revenueByPayment as $payment)
                                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ ucfirst($payment->payment_method ?? 'No especificado') }}</p>
                                            <p class="text-sm text-slate-600">{{ $payment->count }} transacciones</p>
                                        </div>
                                        <span class="text-lg font-bold text-green-700">Bs. {{ number_format($payment->total, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-slate-600 py-8">No hay datos</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
