<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-lg shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">Reporte Financiero</h2>
                    <p class="text-sm text-gray-600">Ingresos y análisis financiero</p>
                </div>
            </div>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Volver a Reportes
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filtros -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <form method="GET" action="{{ route('reports.financial') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-lg hover:from-purple-600 hover:to-pink-700 transition font-semibold">
                        Filtrar
                    </button>
                    <a href="{{ route('reports.financial.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-lg hover:from-red-600 hover:to-pink-700 transition font-semibold">
                        Descargar PDF
                    </a>
                </form>
            </div>

            <!-- Estadísticas Generales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold uppercase tracking-wide">Ingresos Totales</span>
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ number_format($stats['total_revenue'], 2) }} Bs</p>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold uppercase tracking-wide">Período Anterior</span>
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ number_format($stats['previous_revenue'], 2) }} Bs</p>
                </div>

                <div class="bg-gradient-to-br {{ $stats['revenue_growth'] >= 0 ? 'from-green-500 to-emerald-600' : 'from-red-500 to-pink-600' }} rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold uppercase tracking-wide">Crecimiento</span>
                        @if($stats['revenue_growth'] >= 0)
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        @else
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                        @endif
                    </div>
                    <p class="text-4xl font-bold">{{ $stats['revenue_growth'] >= 0 ? '+' : '' }}{{ number_format($stats['revenue_growth'], 2) }}%</p>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold uppercase tracking-wide">Promedio Diario</span>
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ number_format($stats['average_daily_revenue'], 2) }} Bs</p>
                </div>
            </div>

            <!-- Métodos de Pago -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Ingresos por Método de Pago
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($paymentMethods as $method)
                    <div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg p-6 border border-purple-200">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-lg font-semibold text-gray-800">
                                @if($method->payment_method == 'efectivo')
                                    Efectivo
                                @elseif($method->payment_method == 'tarjeta')
                                    Tarjeta
                                @elseif($method->payment_method == 'qr')
                                    QR
                                @else
                                    {{ ucfirst($method->payment_method) }}
                                @endif
                            </h4>
                            <div class="bg-purple-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">
                                {{ $method->count }}
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($method->total, 2) }} Bs</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $method->count }} transacciones</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ingresos Diarios -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                    Ingresos Diarios
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pedidos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ingresos</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($dailyRevenue as $revenue)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($revenue->date)->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $revenue->orders }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-purple-600">{{ number_format($revenue->revenue, 2) }} Bs</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
