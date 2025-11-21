<x-admin-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500 font-semibold">Panel de Administrador</p>
            <h1 class="text-4xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-base text-gray-600">Resumen de inventario y operaciones del sistema</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Estadísticas Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Items en Inventario -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wide mb-2">Items en Inventario</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $inventorySummary->total_items ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">productos registrados</p>
                    </div>
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stock Total -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wide mb-2">Stock Total</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $inventorySummary->total_stock ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2">unidades disponibles</p>
                    </div>
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Alertas de Stock Bajo -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-red-600 uppercase tracking-wide mb-2">Stock Bajo</p>
                        <p class="text-3xl font-bold text-red-700">{{ $inventorySummary->low_stock_count ?? 0 }}</p>
                        <p class="text-xs text-red-500 mt-2">requieren reposición</p>
                    </div>
                    <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pedidos Pendientes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wide mb-2">Pedidos Activos</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $pendingOrdersCount }}</p>
                        <p class="text-xs text-gray-500 mt-2">en proceso</p>
                    </div>
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Productos con Stock Bajo (2 columnas) -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-900 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Alertas de Stock Bajo
                        </h3>
                        <a href="{{ route('inventory.index') }}" class="text-sm text-gray-300 hover:text-white transition">
                            Ver inventario completo →
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($lowStockProducts->count() > 0)
                        <div class="space-y-3">
                            @foreach($lowStockProducts as $item)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-red-300 transition">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                                        <p class="text-sm text-gray-600">Mínimo: {{ $item->minimum_stock }} unidades</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-red-600">{{ $item->current_stock }}</p>
                                        <p class="text-xs text-gray-500">disponibles</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500">No hay productos con stock bajo</p>
                            <p class="text-sm text-gray-400 mt-1">Todos los productos están bien abastecidos</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pedidos Pendientes (1 columna) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-900 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pedidos Recientes
                    </h3>
                </div>
                <div class="p-6">
                    @if($recentPendingOrders->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentPendingOrders as $order)
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="font-semibold text-gray-900">Pedido #{{ $order->id }}</p>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($order->status == 'pendiente') bg-yellow-100 text-yellow-800
                                            @elseif($order->status == 'en_preparacion') bg-blue-100 text-blue-800
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">{{ $order->user->name ?? 'Cliente' }}</p>
                                    <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                                        <span class="text-lg font-bold text-gray-900">Bs {{ number_format($order->total, 2) }}</span>
                                        <a href="{{ route('orders.show', $order) }}" class="text-xs text-gray-700 hover:text-gray-900 font-medium">
                                            Ver →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-500 text-sm">No hay pedidos pendientes</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actividad Reciente de Inventario -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-900 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Actividad Reciente de Inventario
                </h3>
            </div>
            <div class="p-6">
                @if($recentInventoryActivity->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($recentInventoryActivity as $item)
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="font-semibold text-gray-900 mb-1">{{ $item->name }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-gray-700">{{ $item->current_stock }}</span>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-sm">No hay actividad reciente</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-900 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-white">Acciones Rápidas</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <a href="{{ route('inventory.index') }}"
                       class="flex flex-col items-center p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200 hover:border-gray-300">
                        <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 text-center">Ver Inventario</span>
                    </a>

                    <a href="{{ route('orders.index') }}"
                       class="flex flex-col items-center p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200 hover:border-gray-300">
                        <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 text-center">Gestionar Pedidos</span>
                    </a>

                    <a href="{{ route('orders.create') }}"
                       class="flex flex-col items-center p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200 hover:border-gray-300">
                        <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 text-center">Nuevo Pedido</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
