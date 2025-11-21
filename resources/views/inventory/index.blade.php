<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Gestión de Inventario
            </h2>
            <div class="text-sm text-gray-600">
                Total de productos: <span class="font-bold text-gray-900">{{ $inventories->count() }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes de éxito/error -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-green-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-red-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <p class="text-sm font-medium text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium text-blue-700">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            <!-- Alertas de Stock Bajo -->
            @if($lowStock->count() > 0)
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-red-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-red-700">
                                ⚠️ Alerta: {{ $lowStock->count() }} producto(s) con stock bajo
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Tabla de Inventario -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Producto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Categoría
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stock Actual
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stock Mínimo
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stock Máximo
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unidad
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Último Restock
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($inventories as $inventory)
                                    @if($inventory->product)
                                        @php
                                            $stockStatus = 'normal';
                                            $rowBgClass = 'bg-white hover:bg-gray-50';

                                            if($inventory->current_stock <= $inventory->minimum_stock) {
                                                $stockStatus = 'critical';
                                                $rowBgClass = 'bg-red-50 hover:bg-red-100';
                                            } elseif($inventory->current_stock <= $inventory->minimum_stock * 1.5) {
                                                $stockStatus = 'warning';
                                                $rowBgClass = 'bg-yellow-50 hover:bg-yellow-100';
                                            } else {
                                                $rowBgClass = 'bg-green-50 hover:bg-green-100';
                                            }
                                        @endphp

                                        <tr class="{{ $rowBgClass }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center text-white font-bold">
                                                        {{ substr($inventory->product->name, 0, 2) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $inventory->product->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            Bs {{ number_format($inventory->product->price, 2) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ $inventory->product->category->name ?? 'Sin categoría' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="text-2xl font-bold
                                                @if($inventory->current_stock <= $inventory->minimum_stock) text-red-700
                                                @elseif($inventory->current_stock <= $inventory->minimum_stock * 1.5) text-yellow-700
                                                @else text-green-700
                                                @endif">
                                                {{ number_format($inventory->current_stock, 0) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                            {{ number_format($inventory->minimum_stock, 0) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                            {{ number_format($inventory->maximum_stock, 0) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                            {{ $inventory->unit ?? 'unidades' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($inventory->current_stock <= $inventory->minimum_stock)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-300">
                                                    🔴 Crítico
                                                </span>
                                            @elseif($inventory->current_stock <= $inventory->minimum_stock * 1.5)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-300">
                                                    ⚠️ Bajo
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-300">
                                                    ✅ Normal
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                            {{ $inventory->last_restock_date ? $inventory->last_restock_date->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- Botón Agregar Stock (+) -->
                                                <button
                                                    onclick="openAddStockModal({{ $inventory->id }}, '{{ $inventory->product->name }}')"
                                                    class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-colors duration-150 shadow-sm"
                                                    title="Agregar stock">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </button>

                                                <!-- Botón Descontar Stock (-) -->
                                                <button
                                                    onclick="openSubtractStockModal({{ $inventory->id }}, '{{ $inventory->product->name }}', {{ $inventory->current_stock }})"
                                                    class="inline-flex items-center px-3 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-lg transition-colors duration-150 shadow-sm"
                                                    title="Descontar stock">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                    </svg>
                                                </button>

                                                <!-- Botón Reabastecer -->
                                                @if($inventory->current_stock < $inventory->maximum_stock)
                                                    <form action="{{ route('inventory.restock', $inventory->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button
                                                            type="submit"
                                                            onclick="return confirm('¿Reabastecer al stock máximo ({{ $inventory->maximum_stock }})?')"
                                                            class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors duration-150 shadow-sm"
                                                            title="Reabastecer al máximo">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Botón Editar -->
                                                <a href="{{ route('inventory.edit', $inventory->id) }}"
                                                   class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-xs font-bold rounded-lg transition-colors duration-150 shadow-sm"
                                                   title="Editar inventario">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                                <p class="text-gray-500">No hay inventario registrado</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Stock -->
    <div id="addStockModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Agregar Stock</h3>
                    <button onclick="closeAddStockModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form id="addStockForm" method="POST" action="">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Producto</label>
                        <p id="addStockProductName" class="text-gray-900 font-semibold"></p>
                    </div>
                    <div class="mb-4">
                        <label for="add_quantity" class="block text-sm font-medium text-gray-700 mb-2">Cantidad a agregar</label>
                        <input
                            type="number"
                            id="add_quantity"
                            name="quantity"
                            step="1"
                            min="1"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            placeholder="Ej: 10">
                    </div>
                    <div class="mb-4">
                        <label for="add_reason" class="block text-sm font-medium text-gray-700 mb-2">Motivo (opcional)</label>
                        <input
                            type="text"
                            id="add_reason"
                            name="reason"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            placeholder="Ej: Compra nueva">
                    </div>
                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-150">
                            Agregar Stock
                        </button>
                        <button
                            type="button"
                            onclick="closeAddStockModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors duration-150">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Descontar Stock -->
    <div id="subtractStockModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Descontar Stock</h3>
                    <button onclick="closeSubtractStockModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form id="subtractStockForm" method="POST" action="">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Producto</label>
                        <p id="subtractStockProductName" class="text-gray-900 font-semibold"></p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock actual</label>
                        <p id="subtractStockCurrentStock" class="text-gray-900 font-semibold text-lg"></p>
                    </div>
                    <div class="mb-4">
                        <label for="subtract_quantity" class="block text-sm font-medium text-gray-700 mb-2">Cantidad a descontar</label>
                        <input
                            type="number"
                            id="subtract_quantity"
                            name="quantity"
                            step="1"
                            min="1"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            placeholder="Ej: 5">
                    </div>
                    <div class="mb-4">
                        <label for="subtract_reason" class="block text-sm font-medium text-gray-700 mb-2">Motivo (opcional)</label>
                        <input
                            type="text"
                            id="subtract_reason"
                            name="reason"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            placeholder="Ej: Producto dañado">
                    </div>
                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-150">
                            Descontar Stock
                        </button>
                        <button
                            type="button"
                            onclick="closeSubtractStockModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors duration-150">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAddStockModal(inventoryId, productName) {
            document.getElementById('addStockForm').action = `/inventory/${inventoryId}/add-stock`;
            document.getElementById('addStockProductName').textContent = productName;
            document.getElementById('add_quantity').value = '';
            document.getElementById('add_reason').value = '';
            document.getElementById('addStockModal').classList.remove('hidden');
        }

        function closeAddStockModal() {
            document.getElementById('addStockModal').classList.add('hidden');
        }

        function openSubtractStockModal(inventoryId, productName, currentStock) {
            document.getElementById('subtractStockForm').action = `/inventory/${inventoryId}/subtract-stock`;
            document.getElementById('subtractStockProductName').textContent = productName;
            document.getElementById('subtractStockCurrentStock').textContent = currentStock + ' unidades';
            document.getElementById('subtract_quantity').value = '';
            document.getElementById('subtract_quantity').max = currentStock;
            document.getElementById('subtract_reason').value = '';
            document.getElementById('subtractStockModal').classList.remove('hidden');
        }

        function closeSubtractStockModal() {
            document.getElementById('subtractStockModal').classList.add('hidden');
        }

        // Cerrar modales al hacer clic fuera de ellos
        window.onclick = function(event) {
            const addModal = document.getElementById('addStockModal');
            const subtractModal = document.getElementById('subtractStockModal');

            if (event.target === addModal) {
                closeAddStockModal();
            }
            if (event.target === subtractModal) {
                closeSubtractStockModal();
            }
        }

        // Cerrar modales con tecla ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAddStockModal();
                closeSubtractStockModal();
            }
        });
    </script>
</x-app-layout>