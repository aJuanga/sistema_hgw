<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Editar Inventario: {{ $inventory->product->name }}
            </h2>
            <a href="{{ route('inventory.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Volver al inventario
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('inventory.update', $inventory->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Información del Producto -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center text-white font-bold text-2xl">
                                    {{ substr($inventory->product->name, 0, 2) }}
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $inventory->product->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $inventory->product->category->name ?? 'Sin categoría' }}</p>
                                    <p class="text-sm font-semibold text-green-600">Precio: Bs {{ number_format($inventory->product->price, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Actual -->
                        <div class="mb-4">
                            <label for="current_stock" class="block text-sm font-medium text-gray-700 mb-2">
                                Stock Actual <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="current_stock" 
                                   id="current_stock" 
                                   step="0.01"
                                   value="{{ old('current_stock', $inventory->current_stock) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-2xl font-bold text-center py-4"
                                   required>
                            @error('current_stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <!-- Stock Mínimo -->
                            <div>
                                <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stock Mínimo <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="minimum_stock" 
                                       id="minimum_stock" 
                                       step="0.01"
                                       value="{{ old('minimum_stock', $inventory->minimum_stock) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                                @error('minimum_stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock Máximo -->
                            <div>
                                <label for="maximum_stock" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stock Máximo <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="maximum_stock" 
                                       id="maximum_stock" 
                                       step="0.01"
                                       value="{{ old('maximum_stock', $inventory->maximum_stock) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                                @error('maximum_stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Unidad de Medida -->
                        <div class="mb-4">
                            <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                                Unidad de Medida
                            </label>
                            <select name="unit" 
                                    id="unit"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="unidades" {{ old('unit', $inventory->unit) == 'unidades' ? 'selected' : '' }}>Unidades</option>
                                <option value="kilogramos" {{ old('unit', $inventory->unit) == 'kilogramos' ? 'selected' : '' }}>Kilogramos (kg)</option>
                                <option value="gramos" {{ old('unit', $inventory->unit) == 'gramos' ? 'selected' : '' }}>Gramos (g)</option>
                                <option value="litros" {{ old('unit', $inventory->unit) == 'litros' ? 'selected' : '' }}>Litros (L)</option>
                                <option value="mililitros" {{ old('unit', $inventory->unit) == 'mililitros' ? 'selected' : '' }}>Mililitros (ml)</option>
                            </select>
                            @error('unit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Último Restock -->
                        <div class="mb-6">
                            <label for="last_restock_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Último Restock
                            </label>
                            <input type="date" 
                                   name="last_restock_date" 
                                   id="last_restock_date" 
                                   value="{{ old('last_restock_date', $inventory->last_restock_date ? $inventory->last_restock_date->format('Y-m-d') : '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('last_restock_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado Actual -->
                        <div class="mb-6 p-4 rounded-lg @if($inventory->current_stock <= $inventory->minimum_stock) bg-red-50 border border-red-200 @elseif($inventory->current_stock <= $inventory->minimum_stock * 2) bg-yellow-50 border border-yellow-200 @else bg-green-50 border border-green-200 @endif">
                            <p class="text-sm font-medium @if($inventory->current_stock <= $inventory->minimum_stock) text-red-800 @elseif($inventory->current_stock <= $inventory->minimum_stock * 2) text-yellow-800 @else text-green-800 @endif">
                                Estado del Stock: 
                                @if($inventory->current_stock <= $inventory->minimum_stock)
                                    🔴 CRÍTICO - Requiere reposición inmediata
                                @elseif($inventory->current_stock <= $inventory->minimum_stock * 2)
                                    ⚠️ BAJO - Considere reponer pronto
                                @else
                                    ✅ NORMAL - Stock en niveles óptimos
                                @endif
                            </p>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('inventory.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-medium">
                                💾 Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>