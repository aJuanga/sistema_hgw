<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-sm uppercase tracking-[0.4em] text-emerald-400">Panel de Empleado</p>
            <h1 class="text-3xl font-semibold text-slate-900">Mi Dashboard</h1>
            <p class="text-sm text-slate-500">Aquí puedes ver tus pedidos realizados y puntos acumulados.</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filtros de Fecha -->
    <section class="mb-8">
        <form method="GET" action="{{ route('employee.dashboard') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="grid md:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-slate-700 mb-2">Fecha Inicio</label>
                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ $startDate }}"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring focus:ring-emerald-100"
                    >
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-slate-700 mb-2">Fecha Fin</label>
                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ $endDate }}"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring focus:ring-emerald-100"
                    >
                </div>
                <div>
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 transition hover:bg-emerald-600"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </section>

    <!-- Tarjetas de Estadísticas -->
    <section class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Puntos -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-xl shadow-emerald-500/30 p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs uppercase tracking-wider opacity-80">Total Acumulado</span>
            </div>
            <div class="space-y-1">
                <p class="text-3xl font-bold">{{ $totalPoints }} pts</p>
                <p class="text-emerald-100 text-sm">Bs. {{ number_format($totalAmount, 2) }}</p>
            </div>
        </div>

        <!-- Puntos de Hoy -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-xl shadow-amber-500/30 p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs uppercase tracking-wider opacity-80">Hoy</span>
            </div>
            <div class="space-y-1">
                <p class="text-3xl font-bold">{{ $todayPoints }} pts</p>
                <p class="text-amber-100 text-sm">Bs. {{ number_format($todayAmount, 2) }}</p>
            </div>
        </div>

        <!-- Total Pedidos -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="text-xs uppercase tracking-wider text-slate-500">Total Pedidos</span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $totalOrdersCount }}</p>
        </div>

        <!-- Pedidos Completados -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs uppercase tracking-wider text-slate-500">Completados</span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $completedOrdersCount }}</p>
        </div>
    </section>

    <!-- Puntos por Día -->
    @if($pointsByDay->isNotEmpty())
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-slate-900 mb-4">Puntos por Día (Período Seleccionado)</h2>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Puntos</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Monto (Bs.)</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Transacciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($pointsByDay as $dayPoint)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                        {{ \Carbon\Carbon::parse($dayPoint->date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-semibold">
                                            {{ $dayPoint->total_points }} pts
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">
                                        Bs. {{ number_format($dayPoint->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                        {{ $dayPoint->total_transactions }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endif

    <!-- Historial de Pedidos -->
    <section>
        <h2 class="text-2xl font-semibold text-slate-900 mb-4">Mis Pedidos (Período Seleccionado)</h2>

        @if($orders->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-10 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-700">No hay pedidos en este período</h3>
                <p class="text-sm text-slate-500 mt-2">Aún no has realizado pedidos en las fechas seleccionadas.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">{{ $order->order_number }}</h3>
                                <p class="text-sm text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    @if($order->status === 'pendiente') bg-amber-100 text-amber-700
                                    @elseif($order->status === 'en_preparacion') bg-blue-100 text-blue-700
                                    @elseif($order->status === 'listo') bg-purple-100 text-purple-700
                                    @elseif($order->status === 'entregado') bg-emerald-100 text-emerald-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                                <p class="text-lg font-bold text-slate-900 mt-2">Bs. {{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>

                        <!-- Items del Pedido -->
                        <div class="border-t border-slate-100 pt-4">
                            <h4 class="text-sm font-semibold text-slate-700 mb-3">Productos:</h4>
                            <div class="space-y-2">
                                @foreach($order->orderItems as $item)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-700">{{ $item->quantity }}x {{ $item->product->name ?? 'Producto eliminado' }}</span>
                                        <span class="font-semibold text-slate-900">Bs. {{ number_format($item->subtotal, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="mt-4 pt-4 border-t border-slate-100 flex justify-end">
                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-6">
                {{ $orders->appends(['start_date' => $startDate, 'end_date' => $endDate])->links() }}
            </div>
        @endif
    </section>
</x-app-layout>
