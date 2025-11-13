<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-slate-900">Reporte de Clientes</h2>
                <p class="text-sm text-slate-600 mt-1">Análisis de actividad y comportamiento</p>
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

            <!-- Filtros -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('reports.customers') }}" class="flex flex-wrap items-end gap-4">
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
                    <div class="w-32">
                        <label for="limit" class="block text-sm font-semibold text-slate-700 mb-2">Top</label>
                        <select id="limit" name="limit" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('limit') == 20 || !request('limit') ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filtrar
                    </button>
                </form>
            </div>

            <!-- Estadísticas Generales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Clientes Activos -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">{{ $activeCustomers }}</p>
                    <p class="text-sm font-medium text-slate-600">Clientes Activos</p>
                </div>

                <!-- Nuevos Clientes -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">{{ $newCustomers }}</p>
                    <p class="text-sm font-medium text-slate-600">Nuevos Registros</p>
                </div>
            </div>

            <!-- Top Clientes -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Top Clientes por Gasto</h3>
                </div>
                <div class="p-6">
                    @if($topCustomers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Cliente</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Pedidos</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Gasto Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Ticket Promedio</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Último Pedido</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($topCustomers as $index => $customer)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $customer->name }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700">{{ $customer->email }}</td>
                                            <td class="px-6 py-4 text-sm font-semibold text-amber-700">{{ $customer->order_count }}</td>
                                            <td class="px-6 py-4 text-sm font-semibold text-green-700">Bs. {{ number_format($customer->total_spent, 2) }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700">Bs. {{ number_format($customer->avg_order_value, 2) }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700">
                                                {{ \Carbon\Carbon::parse($customer->last_order_date)->locale('es')->diffForHumans() }}
                                            </td>
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

            <!-- Frecuencia de Compra -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Distribución por Frecuencia de Compra</h3>
                </div>
                <div class="p-6">
                    @if($customersByFrequency->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($customersByFrequency as $freq)
                                <div class="p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg border border-slate-200">
                                    <div class="text-center">
                                        <p class="text-3xl font-bold text-slate-900 mb-2">{{ $freq->customer_count }}</p>
                                        <p class="text-sm font-medium text-slate-600">{{ $freq->frequency }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-slate-600 py-8">No hay datos para el período seleccionado</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
