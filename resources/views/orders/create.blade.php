<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🛒 Nuevo Pedido
            </h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Volver a pedidos
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                        @csrf

                        <!-- Cliente -->
                        <div class="mb-6">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Cliente <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id" 
                                    id="user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <option value="">Seleccionar cliente...</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Productos -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Productos <span class="text-red-500">*</span>
                            </label>
                            
                            <div id="productsContainer" class="space-y-3">
                                <!-- Primera fila de producto -->
                                <div class="flex gap-3 items-start bg-gray-50 p-3 rounded-lg" id="product-row-0">
                                    <div class="flex-1">
                                        <select name="items[0][product_id]" 
                                                class="product-select block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                onchange="updateTotal()"
                                                required>
                                            <option value="">Seleccionar producto...</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" 
                                                        data-price="{{ $product->price }}" 
                                                        data-stock="{{ $product->current_stock }}">
                                                    {{ $product->name }} - Bs {{ number_format($product->price, 2) }} (Stock: {{ $product->current_stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-24">
                                        <input type="number" 
                                               name="items[0][quantity]" 
                                               class="quantity-input block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="Cant."
                                               min="1"
                                               value="1"
                                               onchange="updateTotal()"
                                               required>
                                    </div>
                                    <button type="button" 
                                            onclick="removeProductRow(0)"
                                            class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                        🗑️
                                    </button>
                                </div>
                            </div>

                            <button type="button" 
                                    onclick="addProductRow()"
                                    class="mt-3 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                + Agregar Producto
                            </button>
                        </div>

                        <!-- Método de Pago -->
                        <div class="mb-6">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                Método de Pago
                            </label>
                            <select name="payment_method" 
                                    id="payment_method"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="efectivo">💵 Efectivo</option>
                                <option value="tarjeta">💳 Tarjeta</option>
                                <option value="transferencia">🏦 Transferencia</option>
                            </select>
                        </div>

                        <!-- Estado de Pago -->
                        <div class="mb-6">
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">
                                Estado de Pago
                            </label>
                            <select name="payment_status" 
                                    id="payment_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="pendiente">⏳ Pendiente</option>
                                <option value="pagado">✅ Pagado</option>
                            </select>
                        </div>

                        <!-- Dirección y Teléfono -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Dirección de Entrega
                                </label>
                                <input type="text" 
                                       name="delivery_address" 
                                       id="delivery_address" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="Ej: Calle 21, La Paz">
                            </div>
                            <div>
                                <label for="delivery_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Teléfono de Contacto
                                </label>
                                <input type="text" 
                                       name="delivery_phone" 
                                       id="delivery_phone" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="Ej: 71234567">
                            </div>
                        </div>

                        <!-- Notas -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notas del Pedido
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                      placeholder="Instrucciones especiales, alergias, etc.">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-700">Total Estimado:</span>
                                <span id="totalDisplay" class="text-2xl font-bold text-green-600">Bs 0.00</span>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('orders.index') }}" 
                               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-medium">
                                💾 Crear Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const products = @json($products);
        let productRowIndex = 1; // Empezamos en 1 porque ya existe la fila 0

        function addProductRow() {
            const container = document.getElementById('productsContainer');
            const index = productRowIndex++;
            
            const row = document.createElement('div');
            row.className = 'flex gap-3 items-start bg-gray-50 p-3 rounded-lg';
            row.id = `product-row-${index}`;
            
            let optionsHTML = '<option value="">Seleccionar producto...</option>';
            products.forEach(p => {
                optionsHTML += `<option value="${p.id}" data-price="${p.price}" data-stock="${p.current_stock}">
                    ${p.name} - Bs ${parseFloat(p.price).toFixed(2)} (Stock: ${p.current_stock})
                </option>`;
            });
            
            row.innerHTML = `
                <div class="flex-1">
                    <select name="items[${index}][product_id]" 
                            class="product-select block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            onchange="updateTotal()"
                            required>
                        ${optionsHTML}
                    </select>
                </div>
                <div class="w-24">
                    <input type="number" 
                           name="items[${index}][quantity]" 
                           class="quantity-input block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="Cant."
                           min="1"
                           value="1"
                           onchange="updateTotal()"
                           required>
                </div>
                <button type="button" 
                        onclick="removeProductRow(${index})"
                        class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                    🗑️
                </button>
            `;
            
            container.appendChild(row);
            updateTotal();
        }

        function removeProductRow(index) {
            const row = document.getElementById(`product-row-${index}`);
            if (row) {
                row.remove();
                updateTotal();
            }
        }

        function updateTotal() {
            let total = 0;
            const rows = document.querySelectorAll('#productsContainer > div');
            
            rows.forEach(row => {
                const select = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');
                
                if (select && quantityInput && select.value) {
                    const selectedOption = select.options[select.selectedIndex];
                    const price = parseFloat(selectedOption.dataset.price) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    total += price * quantity;
                }
            });
            
            document.getElementById('totalDisplay').textContent = `Bs ${total.toFixed(2)}`;
        }

        // Validar antes de enviar
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            const rows = document.querySelectorAll('#productsContainer > div');
            if (rows.length === 0) {
                e.preventDefault();
                alert('Debes agregar al menos un producto al pedido');
                return false;
            }
        });
    </script>
    @endpush
</x-app-layout>