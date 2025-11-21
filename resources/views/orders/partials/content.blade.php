<!-- Botón Crear Pedido -->
<div class="mb-8">
    <a href="{{ route('orders.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 transition transform hover:-translate-y-0.5">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Nuevo Pedido
    </a>
</div>

<!-- Estadísticas Rápidas -->
<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-gradient-to-br from-slate-500 to-slate-600 rounded-2xl shadow-xl shadow-slate-500/30 p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <span class="text-xs uppercase tracking-wider opacity-80">Total</span>
        </div>
        <p class="text-3xl font-bold">{{ $orders->count() }}</p>
    </div>

    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-xl shadow-amber-500/30 p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs uppercase tracking-wider opacity-80">Pendientes</span>
        </div>
        <p class="text-3xl font-bold">{{ $orders->where('status', 'pendiente')->count() }}</p>
    </div>

    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl shadow-blue-500/30 p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </div>
            <span class="text-xs uppercase tracking-wider opacity-80">En Preparación</span>
        </div>
        <p class="text-3xl font-bold">{{ $orders->where('status', 'en_preparacion')->count() }}</p>
    </div>

    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-xl shadow-emerald-500/30 p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs uppercase tracking-wider opacity-80">Completados</span>
        </div>
        <p class="text-3xl font-bold">{{ $orders->whereIn('status', ['listo', 'entregado'])->count() }}</p>
    </div>

    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-xl shadow-red-500/30 p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <span class="text-xs uppercase tracking-wider opacity-80">Cancelados</span>
        </div>
        <p class="text-3xl font-bold">{{ $orders->where('status', 'cancelado')->count() }}</p>
    </div>
</section>

<!-- Tabla de Pedidos -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
        <h3 class="text-lg font-semibold text-slate-900">Lista de Pedidos</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        N° Pedido
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Cliente
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Productos
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Total
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Estado
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Pago
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Fecha
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-slate-900">{{ $order->order_number }}</div>
                            <div class="text-xs text-slate-500">ID: #{{ $order->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr($order->user->name, 0, 2) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-slate-900">{{ $order->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $order->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                {{ $order->orderItems->count() }} items
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-base font-bold text-emerald-600">Bs {{ number_format($order->total, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($order->status == 'pendiente')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    Pendiente
                                </span>
                            @elseif($order->status == 'en_preparacion')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    En Preparación
                                </span>
                            @elseif($order->status == 'listo')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                    Listo
                                </span>
                            @elseif($order->status == 'entregado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    Entregado
                                </span>
                            @elseif($order->status == 'cancelado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    Cancelado
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($order->payment_status == 'pagado')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    Pagado
                                </span>
                            @elseif($order->payment_status == 'pendiente')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-amber-100 text-amber-700">
                                    Pendiente
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-700">
                                    Rechazado
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-600">
                            <div class="font-medium">{{ $order->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-slate-500">{{ $order->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-xs font-medium">
                                    Ver
                                </a>
                                <a href="{{ route('orders.edit', $order->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-lg hover:bg-emerald-200 transition text-xs font-medium">
                                    Editar
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-700 mb-2">No hay pedidos registrados</h3>
                                <p class="text-sm text-slate-500 mb-4">Comienza creando tu primer pedido</p>
                                <a href="{{ route('orders.create') }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition shadow-md font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Crear Primer Pedido
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
