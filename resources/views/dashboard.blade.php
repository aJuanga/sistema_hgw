<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-lg shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">Dashboard Sistema HGW</h2>
                    <p class="text-sm text-gray-600">Cafetería Saludable</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm text-gray-600">{{ now()->format('d/m/Y') }}</p>
                    <p class="text-xs text-gray-500">{{ now()->format('H:i') }}</p>
                </div>
                <div class="bg-green-100 px-4 py-2 rounded-lg border border-green-300">
                    <p class="text-sm font-medium text-green-700">Sistema Activo</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-orange-50 to-amber-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($error))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-red-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-sm text-red-700 font-medium">{{ $error }}</p>
                    </div>
                </div>
            @endif

            <!-- Estadísticas Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Productos -->
                <div class="bg-gradient-to-br from-orange-500 via-orange-600 to-red-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-white text-sm font-bold mb-2 uppercase tracking-wide">MENÚ DISPONIBLE</p>
                            <p class="text-5xl font-bold text-white">{{ $productsCount ?? 0 }}</p>
                            <p class="text-orange-50 text-xs mt-2">productos activos</p>
                        </div>
                        <div class="bg-white bg-opacity-30 p-4 rounded-xl backdrop-blur-sm">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('products.index') }}" class="text-white text-sm hover:underline flex items-center font-semibold">
                        Ver catálogo completo
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <!-- Categorías -->
                <div class="bg-gradient-to-br from-green-500 via-green-600 to-emerald-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-white text-sm font-bold mb-2 uppercase tracking-wide">CATEGORÍAS</p>
                            <p class="text-5xl font-bold text-white">{{ $categoriesCount ?? 0 }}</p>
                            <p class="text-green-50 text-xs mt-2">secciones del menú</p>
                        </div>
                        <div class="bg-white bg-opacity-30 p-4 rounded-xl backdrop-blur-sm">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('categories.index') }}" class="text-white text-sm hover:underline flex items-center font-semibold">
                        Ver todas las categorías
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <!-- Pedidos -->
                <div class="bg-gradient-to-br from-purple-500 via-purple-600 to-pink-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-white text-sm font-bold mb-2 uppercase tracking-wide">PEDIDOS TOTALES</p>
                            <p class="text-5xl font-bold text-white">{{ $ordersCount ?? 0 }}</p>
                            <p class="text-purple-50 text-xs mt-2">órdenes registradas</p>
                        </div>
                        <div class="bg-white bg-opacity-30 p-4 rounded-xl backdrop-blur-sm">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('orders.index') }}" class="text-white text-sm hover:underline flex items-center font-semibold">
                        Gestionar pedidos
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <!-- Stock Bajo -->
                <div class="bg-gradient-to-br from-red-500 via-red-600 to-pink-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-white text-sm font-bold mb-2 uppercase tracking-wide">ALERTAS STOCK</p>
                            <p class="text-5xl font-bold text-white">{{ $lowStockCount ?? 0 }}</p>
                            <p class="text-red-50 text-xs mt-2">productos a reponer</p>
                        </div>
                        <div class="bg-white bg-opacity-30 p-4 rounded-xl backdrop-blur-sm">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('inventory.index') }}" class="text-white text-sm hover:underline flex items-center font-semibold">
                        Revisar inventario
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Productos Recientes (2 columnas) -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Productos Recientes</h3>
                    </div>
                    <div class="p-6">
                        @if(isset($recentProducts) && $recentProducts->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentProducts as $product)
                                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-orange-50 to-amber-50 rounded-lg hover:shadow-md transition">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow">
                                                {{ substr($product->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $product->category->name ?? 'Sin categoría' }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xl font-bold text-green-600">Bs {{ number_format($product->price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <p class="text-gray-500 mb-4">No hay productos registrados</p>
                                <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                                    Crear primer producto
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pedidos Pendientes (1 columna) -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 via-purple-600 to-pink-500 px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Pedidos Activos</h3>
                    </div>
                    <div class="p-6">
                        @if(isset($pendingOrders) && $pendingOrders->count() > 0)
                            <div class="space-y-3">
                                @foreach($pendingOrders as $order)
                                    <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="font-bold text-gray-900">Pedido #{{ $order->id }}</p>
                                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                                @if($order->status == 'pendiente') bg-yellow-100 text-yellow-800
                                                @elseif($order->status == 'en_preparacion') bg-blue-100 text-blue-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">{{ $order->user->name ?? 'Cliente' }}</p>
                                        <div class="flex items-center justify-between pt-2 border-t border-purple-200">
                                            <span class="text-lg font-bold text-purple-600">Bs {{ number_format($order->total, 2) }}</span>
                                            <a href="{{ route('orders.show', $order) }}" class="text-xs text-purple-600 hover:text-purple-700 font-medium">Ver</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <p class="text-gray-500 text-sm">No hay pedidos pendientes</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">Acciones Rápidas</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('products.create') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-amber-50 to-orange-100 rounded-lg hover:shadow-lg transition border border-amber-200">
                            <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mb-3 shadow">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700 text-center">Nuevo Producto</span>
                        </a>

                        <a href="{{ route('orders.create') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-purple-50 to-pink-100 rounded-lg hover:shadow-lg transition border border-purple-200">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mb-3 shadow">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700 text-center">Nuevo Pedido</span>
                        </a>

                        <a href="{{ route('categories.create') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-green-50 to-emerald-100 rounded-lg hover:shadow-lg transition border border-green-200">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mb-3 shadow">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700 text-center">Nueva Categoría</span>
                        </a>

                        <a href="{{ route('inventory.index') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg hover:shadow-lg transition border border-blue-200">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mb-3 shadow">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700 text-center">Ver Inventario</span>
                        </a>

                        <a href="{{ route('roles.index') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-gray-50 to-gray-200 rounded-lg hover:shadow-lg transition border border-gray-300">
                            <div class="w-14 h-14 bg-gradient-to-br from-gray-600 to-gray-800 rounded-lg flex items-center justify-center mb-3 shadow">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700 text-center">Gestionar Roles</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>