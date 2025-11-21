<x-jefa-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.3em] bg-gradient-to-r from-emerald-600 to-amber-600 bg-clip-text text-transparent font-bold">Panel Ejecutivo</p>
            <h1 class="text-4xl font-bold text-gray-900">Dashboard de Jefa</h1>
            <p class="text-base text-gray-600">Resumen ejecutivo completo del sistema HGW</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Resumen de Ventas -->
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Resumen de Ventas
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Ventas del Día -->
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-emerald-100 text-sm font-bold mb-2 uppercase tracking-wide">Ventas Hoy</p>
                            <p class="text-4xl font-bold">Bs {{ number_format($salesToday, 2) }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-emerald-100 text-xs">{{ Carbon\Carbon::today()->format('d/m/Y') }}</p>
                </div>

                <!-- Ventas de la Semana -->
                <div class="bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-amber-100 text-sm font-bold mb-2 uppercase tracking-wide">Ventas Semana</p>
                            <p class="text-4xl font-bold">Bs {{ number_format($salesWeek, 2) }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-amber-100 text-xs">Últimos 7 días</p>
                </div>

                <!-- Ventas del Mes -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-purple-100 text-sm font-bold mb-2 uppercase tracking-wide">Ventas Mes</p>
                            <p class="text-4xl font-bold">Bs {{ number_format($salesMonth, 2) }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-purple-100 text-xs">{{ Carbon\Carbon::now()->format('F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Estadísticas Generales -->
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-4">Estadísticas Generales</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
                    <p class="text-xs text-gray-600 uppercase tracking-wide mb-1">Productos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
                    <p class="text-xs text-gray-600 uppercase tracking-wide mb-1">Pedidos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-yellow-200 p-4 hover:shadow-md transition">
                    <p class="text-xs text-yellow-600 uppercase tracking-wide mb-1">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ $stats['pending_orders'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-green-200 p-4 hover:shadow-md transition">
                    <p class="text-xs text-green-600 uppercase tracking-wide mb-1">Completados</p>
                    <p class="text-2xl font-bold text-green-700">{{ $stats['completed_orders_month'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-blue-200 p-4 hover:shadow-md transition">
                    <p class="text-xs text-blue-600 uppercase tracking-wide mb-1">Clientes</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $stats['total_customers'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-red-200 p-4 hover:shadow-md transition">
                    <p class="text-xs text-red-600 uppercase tracking-wide mb-1">Stock Bajo</p>
                    <p class="text-2xl font-bold text-red-700">{{ $stats['low_stock_count'] }}</p>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Productos Más Vendidos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Top 5 Productos Más Vendidos
                    </h3>
                </div>
                <div class="p-6">
                    @if($topProducts->count() > 0)
                        <div class="space-y-4">
                            @foreach($topProducts as $index => $product)
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-amber-50 rounded-lg border border-emerald-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-amber-500 rounded-lg flex items-center justify-center text-white font-bold shadow-lg">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $product->total_sold }} unidades vendidas</p>
                                        </div>
                                    </div>
                                    <span class="text-xl font-bold text-emerald-700">Bs {{ number_format($product->total_revenue, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">No hay datos de ventas disponibles</p>
                    @endif
                </div>
            </div>

            <!-- Inventario Crítico -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Inventario Crítico
                        </h3>
                        <a href="{{ route('inventory.index') }}" class="text-sm text-white hover:underline">Ver todo →</a>
                    </div>
                </div>
                <div class="p-6 max-h-96 overflow-y-auto">
                    @if($criticalInventory->count() > 0)
                        <div class="space-y-3">
                            @foreach($criticalInventory as $item)
                                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                                        <p class="text-xs text-gray-600">Mínimo: {{ $item->minimum_stock }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-red-600">{{ $item->current_stock }}</p>
                                        <p class="text-xs text-gray-500">stock</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-green-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500">Todo el inventario está bien abastecido</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Desempeño de Empleados -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Desempeño de Empleados (Este Mes)
                </h3>
            </div>
            <div class="p-6">
                @if($employeePerformance->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($employeePerformance as $employee)
                            <div class="p-4 bg-gradient-to-br from-amber-50 to-emerald-50 rounded-lg border border-amber-200">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($employee->name, 0, 1) }}
                                    </div>
                                    <p class="ml-3 font-bold text-gray-900">{{ $employee->name }}</p>
                                </div>
                                <div class="space-y-1">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Pedidos:</span>
                                        <span class="font-semibold text-gray-900">{{ $employee->orders_processed }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Ventas:</span>
                                        <span class="font-semibold text-emerald-700">Bs {{ number_format($employee->total_sales, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 py-8">No hay datos de desempeño disponibles</p>
                @endif
            </div>
        </div>

        <!-- Pedidos Recientes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Pedidos Recientes
                    </h3>
                    <a href="{{ route('orders.index') }}" class="text-sm text-white hover:underline">Ver todos →</a>
                </div>
            </div>
            <div class="p-6">
                @if($recentOrders->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($recentOrders as $order)
                            <div class="p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-bold text-gray-900">Pedido #{{ $order->id }}</p>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($order->status == 'pendiente') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'en_preparacion') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'completado') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ $order->user->name ?? 'Cliente' }}</p>
                                <div class="pt-2 border-t border-purple-200">
                                    <p class="text-lg font-bold text-purple-700">Bs {{ number_format($order->total, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 py-8">No hay pedidos recientes</p>
                @endif
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Acciones Rápidas</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <a href="{{ route('products.create') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg hover:shadow-lg transition border border-emerald-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-lg flex items-center justify-center mb-3 shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-900 text-center">Nuevo Producto</span>
                    </a>

                    <a href="{{ route('orders.create') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg hover:shadow-lg transition border border-purple-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-purple-700 rounded-lg flex items-center justify-center mb-3 shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-900 text-center">Nuevo Pedido</span>
                    </a>

                    <a href="{{ route('categories.create') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg hover:shadow-lg transition border border-amber-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-600 to-amber-700 rounded-lg flex items-center justify-center mb-3 shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-900 text-center">Nueva Categoría</span>
                    </a>

                    <a href="{{ route('inventory.index') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg hover:shadow-lg transition border border-blue-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center mb-3 shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-900 text-center">Ver Inventario</span>
                    </a>

                    <a href="{{ route('orders.index') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg hover:shadow-lg transition border border-indigo-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-lg flex items-center justify-center mb-3 shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-900 text-center">Gestionar Pedidos</span>
                    </a>

                    <a href="{{ route('reports.index') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg hover:shadow-lg transition border border-pink-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-600 to-pink-700 rounded-lg flex items-center justify-center mb-3 shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-900 text-center">Reportes</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-jefa-layout>
