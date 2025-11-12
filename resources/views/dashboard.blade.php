<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    @if(isset($error))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ $error }}</p>
                    <p class="text-sm text-red-600 mt-2">
                        <strong>Solución:</strong> Abre pgAdmin, crea la base de datos <code class="bg-red-100 px-1 rounded">hgw_db</code> en el puerto <code class="bg-red-100 px-1 rounded">5433</code>, 
                        luego ejecuta <code class="bg-red-100 px-1 rounded">php artisan migrate</code>
                    </p>
                </div>
            </div>
        </div>
    @endif

    @php
        $user = Auth::user();
        $canManageCatalog = $user?->hasAnyRole(['jefa', 'administrador']);
        $canManageOperations = $user?->hasAnyRole(['jefa', 'administrador', 'empleado']);
        $isCliente = $user?->isCliente();
    @endphp

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Categories Card -->
        <div class="bg-white rounded-lg shadow p-6 {{ !$canManageCatalog ? 'opacity-60' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Categorías</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $categoriesCount ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('categories.index') }}" class="text-sm text-blue-600 hover:text-blue-800 mt-4 inline-block">
                Ver todas →
            </a>
        </div>

        <!-- Products Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Productos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $productsCount ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm text-green-600 hover:text-green-800 mt-4 inline-block">
                Ver todos →
            </a>
        </div>

        <!-- Diseases Card -->
        <div class="bg-white rounded-lg shadow p-6 {{ !$canManageCatalog ? 'opacity-60' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Enfermedades</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $diseasesCount ?? 0 }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('diseases.index') }}" class="text-sm text-red-600 hover:text-red-800 mt-4 inline-block">
                Ver todas →
            </a>
        </div>

        <!-- Health Properties Card -->
        <div class="bg-white rounded-lg shadow p-6 {{ !$canManageCatalog ? 'opacity-60' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Propiedades Saludables</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $healthPropertiesCount ?? 0 }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('health-properties.index') }}" class="text-sm text-purple-600 hover:text-purple-800 mt-4 inline-block">
                Ver todas →
            </a>
        </div>
    </div>

    <!-- Quick Actions & Recent Items -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>

            @if($canManageCatalog || $canManageOperations)
                <div class="space-y-3">
                    @if($canManageCatalog)
                        <a href="{{ route('categories.create') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Nueva Categoría</span>
                        </a>
                        <a href="{{ route('products.create') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="p-2 bg-green-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Nuevo Producto</span>
                        </a>
                        <a href="{{ route('diseases.create') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="p-2 bg-red-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Nueva Enfermedad</span>
                        </a>
                        <a href="{{ route('health-properties.create') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Nueva Propiedad Saludable</span>
                        </a>
                    @endif

                    @if($canManageOperations)
                        <a href="{{ route('orders.create') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8m12-5V7a2 2 0 00-2-2h-1.172a2 2 0 01-1.414-.586l-1.828-1.828A2 2 0 0013.172 2h-2.344a2 2 0 00-1.414.586L7.586 4.414A2 2 0 016.172 5H5a2 2 0 00-2 2v1"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Nuevo Pedido</span>
                        </a>
                        <a href="{{ route('inventory.create') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-3V3a1 1 0 00-1-1h-4a1 1 0 00-1 1v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Registrar Movimiento</span>
                        </a>
                    @endif
                </div>
            @else
                <div class="bg-gray-50 border border-dashed border-gray-200 rounded-lg p-4 text-center text-gray-500">
                    <p>No tienes acciones administrativas disponibles.</p>
                    <p class="text-sm mt-2">Puedes ver los productos en el menú lateral y realizar pedidos desde la tienda.</p>
                </div>
            @endif
        </div>

        <!-- Recent Products -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Productos Recientes</h3>
            <div class="space-y-3">
                @forelse(($recentProducts ?? collect([])) as $product)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded object-cover mr-3">
                            @else
                                <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">Bs. {{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                        @if($canManageCatalog)
                            <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>No hay productos registrados</p>
                        @if($canManageCatalog)
                            <a href="{{ route('products.create') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                                Crear el primero →
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>