<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-slate-900">Panel de Control</h2>
                <p class="text-sm text-slate-600 mt-1">Sistema de Gestión - Healthy Glow Wellness</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="px-4 py-2 bg-slate-100 rounded-lg border border-slate-200">
                    <span class="text-sm text-slate-700 font-medium">{{ now()->locale('es')->isoFormat('D MMM YYYY') }}</span>
                </div>
                <div class="px-4 py-2 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-sm text-green-700 font-semibold">Sistema Activo</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($error))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-sm text-red-700 font-medium">{{ $error }}</p>
                    </div>
                </div>
            @endif

            <!-- Estadísticas Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <!-- Card Productos -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold text-slate-900">{{ $productsCount ?? 0 }}</p>
                        <p class="text-sm font-medium text-slate-600">Productos</p>
                        <a href="{{ route('products.index') }}" class="text-xs text-amber-700 hover:text-amber-800 font-medium inline-flex items-center mt-2">
                            Ver catálogo
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card Categorías -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold text-slate-900">{{ $categoriesCount ?? 0 }}</p>
                        <p class="text-sm font-medium text-slate-600">Categorías</p>
                        <a href="{{ route('categories.index') }}" class="text-xs text-amber-700 hover:text-amber-800 font-medium inline-flex items-center mt-2">
                            Administrar
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card Pedidos -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold text-slate-900">{{ $ordersCount ?? 0 }}</p>
                        <p class="text-sm font-medium text-slate-600">Pedidos Totales</p>
                        <a href="{{ route('orders.index') }}" class="text-xs text-amber-700 hover:text-amber-800 font-medium inline-flex items-center mt-2">
                            Ver pedidos
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card Usuarios -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold text-slate-900">{{ \App\Models\User::count() }}</p>
                        <p class="text-sm font-medium text-slate-600">Usuarios</p>
                        @if(auth()->user()->hasRole('jefa') || auth()->user()->hasRole('administrador'))
                            <a href="{{ route('users.index') }}" class="text-xs text-amber-700 hover:text-amber-800 font-medium inline-flex items-center mt-2">
                                Gestionar
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Card Stock -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold text-slate-900">{{ $lowStockCount ?? 0 }}</p>
                        <p class="text-sm font-medium text-slate-600">Alertas Stock</p>
                        @if(auth()->user()->hasRole('jefa'))
                            <a href="{{ route('inventory.index') }}" class="text-xs text-amber-700 hover:text-amber-800 font-medium inline-flex items-center mt-2">
                                Ver inventario
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Productos Recientes -->
                <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Productos Recientes</h3>
                    </div>
                    <div class="p-6">
                        @if(isset($recentProducts) && $recentProducts->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentProducts as $product)
                                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 hover:border-amber-300 transition-colors">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-amber-700">{{ strtoupper(substr($product->name, 0, 2)) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                                                <p class="text-sm text-slate-600">{{ $product->category->name ?? 'Sin categoría' }}</p>
                                            </div>
                                        </div>
                                        <span class="text-lg font-bold text-amber-700">Bs {{ number_format($product->price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <p class="text-slate-600 mb-4">No hay productos registrados</p>
                                <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition font-medium">
                                    Crear primer producto
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pedidos Pendientes -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Pedidos Activos</h3>
                    </div>
                    <div class="p-6">
                        @if(isset($pendingOrders) && $pendingOrders->count() > 0)
                            <div class="space-y-3">
                                @foreach($pendingOrders as $order)
                                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="font-semibold text-slate-900">Pedido #{{ $order->id }}</p>
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                @if($order->status == 'pendiente') bg-amber-100 text-amber-800 border border-amber-200
                                                @elseif($order->status == 'en_preparacion') bg-blue-100 text-blue-800 border border-blue-200
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-slate-600 mb-2">{{ $order->user->name ?? 'Cliente' }}</p>
                                        <div class="flex items-center justify-between pt-2 border-t border-slate-200">
                                            <span class="text-base font-bold text-slate-900">Bs {{ number_format($order->total, 2) }}</span>
                                            <a href="{{ route('orders.show', $order) }}" class="text-xs text-amber-700 hover:text-amber-800 font-medium">Ver detalles</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-slate-600">No hay pedidos pendientes</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            @if(auth()->user()->hasRole('jefa'))
            <!-- Sección de Reportes para Jefa -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-8">
                <div class="px-6 py-4 border-b border-slate-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-900">Reportes y Análisis</h3>
                        <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Reporte de Ventas -->
                        <a href="{{ route('reports.sales') }}" class="group flex flex-col p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg border border-green-200 hover:border-green-300 hover:shadow-md transition-all">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <svg class="w-5 h-5 text-green-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Reporte de Ventas</h4>
                            <p class="text-sm text-slate-600">Ingresos, pedidos y estadísticas por período</p>
                        </a>

                        <!-- Productos Más Vendidos -->
                        <a href="{{ route('reports.products') }}" class="group flex flex-col p-6 bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg border border-amber-200 hover:border-amber-300 hover:shadow-md transition-all">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <svg class="w-5 h-5 text-amber-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Productos Más Vendidos</h4>
                            <p class="text-sm text-slate-600">Top productos y análisis de popularidad</p>
                        </a>

                        <!-- Reporte de Clientes -->
                        <a href="{{ route('reports.customers') }}" class="group flex flex-col p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border border-blue-200 hover:border-blue-300 hover:shadow-md transition-all">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <svg class="w-5 h-5 text-blue-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Reporte de Clientes</h4>
                            <p class="text-sm text-slate-600">Actividad de clientes y frecuencia de compra</p>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Acciones Rápidas</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <a href="{{ route('products.create') }}" class="group flex flex-col items-center p-5 bg-slate-50 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition-all">
                            <div class="w-12 h-12 bg-amber-100 group-hover:bg-amber-200 rounded-lg flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center">Nuevo Producto</span>
                        </a>

                        <a href="{{ route('orders.create') }}" class="group flex flex-col items-center p-5 bg-slate-50 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition-all">
                            <div class="w-12 h-12 bg-amber-100 group-hover:bg-amber-200 rounded-lg flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center">Nuevo Pedido</span>
                        </a>

                        <a href="{{ route('categories.create') }}" class="group flex flex-col items-center p-5 bg-slate-50 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition-all">
                            <div class="w-12 h-12 bg-amber-100 group-hover:bg-amber-200 rounded-lg flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 text-center">Nueva Categoría</span>
                        </a>

                        @if(auth()->user()->hasRole('jefa'))
                            <a href="{{ route('inventory.index') }}" class="group flex flex-col items-center p-5 bg-slate-50 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition-all">
                                <div class="w-12 h-12 bg-amber-100 group-hover:bg-amber-200 rounded-lg flex items-center justify-center mb-3 transition-colors">
                                    <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-700 text-center">Ver Inventario</span>
                            </a>

                            <a href="{{ route('roles.index') }}" class="group flex flex-col items-center p-5 bg-slate-50 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition-all">
                                <div class="w-12 h-12 bg-amber-100 group-hover:bg-amber-200 rounded-lg flex items-center justify-center mb-3 transition-colors">
                                    <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-700 text-center">Gestionar Roles</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
