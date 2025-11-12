<x-app-layout>
    <x-slot name="header">
        Agregar Producto al Inventario
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Producto -->
                        <div class="col-span-2">
                            <label for="product_id" class="block text-sm font-medium text-gray-700">Producto *</label>
                            <select name="product_id" id="product_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Seleccionar producto...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Actual -->
                        <div>
                            <label for="current_stock" class="block text-sm font-medium text-gray-700">Stock Actual *</label>
                            <input type="number" name="current_stock" id="current_stock" value="{{ old('current_stock') }}" min="0" step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('current_stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Mínimo -->
                        <div>
                            <label for="minimum_stock" class="block text-sm font-medium text-gray-700">Stock Mínimo *</label>
                            <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock') }}" min="0" step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('minimum_stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Máximo -->
                        <div>
                            <label for="maximum_stock" class="block text-sm font-medium text-gray-700">Stock Máximo</label>
                            <input type="number" name="maximum_stock" id="maximum_stock" value="{{ old('maximum_stock') }}" min="0" step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('maximum_stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Unidad -->
                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700">Unidad *</label>
                            <input type="text" name="unit" id="unit" value="{{ old('unit') }}" placeholder="unidad, kg, litros"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('unit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Última fecha de reabastecimiento -->
                        <div class="col-span-2">
                            <label for="last_restock_date" class="block text-sm font-medium text-gray-700">Última Fecha de Reabastecimiento</label>
                            <input type="date" name="last_restock_date" id="last_restock_date" value="{{ old('last_restock_date') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('last_restock_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('inventory.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-lg transition">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
