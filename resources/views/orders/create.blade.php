<x-app-layout>
    <x-slot name="header">
        Nuevo Pedido
    </x-slot>

    <div class="max-w-6xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Cliente -->
                        <div class="col-span-2">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Cliente *</label>
                            <select name="user_id" id="user_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Seleccionar cliente...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección de productos -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Productos del Pedido</h3>

                        <div class="grid grid-cols-12 gap-3 mb-3">
                            <div class="col-span-5">
                                <label for="product_select" class="block text-sm font-medium text-gray-700">Producto</label>
                                <select id="product_select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Seleccionar producto...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-name="{{ $product->name }}">
                                            {{ $product->name }} - Bs. {{ number_format($product->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="quantity_input" class="block text-sm font-medium text-gray-700">Cantidad</label>
                                <input type="number" id="quantity_input" min="1" value="1" step="0.01"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="col-span-2">
                                <label for="price_input" class="block text-sm font-medium text-gray-700">Precio Unit.</label>
                                <input type="number" id="price_input" readonly step="0.01"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                            </div>
                            <div class="col-span-3 flex items-end">
                                <button type="button" id="addProductBtn"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Agregar
                                </button>
                            </div>
                        </div>

                        <!-- Tabla de productos agregados -->
                        <div class="mt-4">
                            <table class="min-w-full divide-y divide-gray-200" id="orderItemsTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Unit.</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="orderItemsBody">
                                    <tr id="emptyRow">
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                            No se han agregado productos
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Total -->
                        <div class="mt-4 flex justify-end">
                            <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                <div class="text-lg font-semibold text-gray-900">
                                    Total: Bs. <span id="orderTotal">0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notas -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notas (Opcional)</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-lg transition">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                            Crear Pedido
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let orderItems = [];
        let itemCounter = 0;

        // Actualizar precio cuando se selecciona un producto
        document.getElementById('product_select').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            document.getElementById('price_input').value = price || '';
        });

        // Agregar producto
        document.getElementById('addProductBtn').addEventListener('click', function() {
            const productSelect = document.getElementById('product_select');
            const quantityInput = document.getElementById('quantity_input');
            const priceInput = document.getElementById('price_input');

            const productId = productSelect.value;
            const productName = productSelect.options[productSelect.selectedIndex].getAttribute('data-name');
            const quantity = parseFloat(quantityInput.value);
            const price = parseFloat(priceInput.value);

            if (!productId || !quantity || !price) {
                alert('Por favor complete todos los campos del producto');
                return;
            }

            const subtotal = quantity * price;

            orderItems.push({
                id: itemCounter,
                product_id: productId,
                product_name: productName,
                quantity: quantity,
                price: price,
                subtotal: subtotal
            });

            addItemToTable(itemCounter, productName, quantity, price, subtotal);
            updateTotal();

            itemCounter++;

            // Limpiar campos
            productSelect.value = '';
            quantityInput.value = 1;
            priceInput.value = '';
        });

        function addItemToTable(id, name, quantity, price, subtotal) {
            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) emptyRow.remove();

            const tbody = document.getElementById('orderItemsBody');
            const row = document.createElement('tr');
            row.id = `item-${id}`;
            row.innerHTML = `
                <td class="px-4 py-3 text-sm text-gray-900">${name}</td>
                <td class="px-4 py-3 text-sm text-gray-900">${quantity}</td>
                <td class="px-4 py-3 text-sm text-gray-900">Bs. ${price.toFixed(2)}</td>
                <td class="px-4 py-3 text-sm text-gray-900">Bs. ${subtotal.toFixed(2)}</td>
                <td class="px-4 py-3">
                    <button type="button" onclick="removeItem(${id})" class="text-red-600 hover:text-red-900">Eliminar</button>
                </td>
            `;
            tbody.appendChild(row);
        }

        function removeItem(id) {
            orderItems = orderItems.filter(item => item.id !== id);
            document.getElementById(`item-${id}`).remove();

            if (orderItems.length === 0) {
                const tbody = document.getElementById('orderItemsBody');
                tbody.innerHTML = `
                    <tr id="emptyRow">
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            No se han agregado productos
                        </td>
                    </tr>
                `;
            }

            updateTotal();
        }

        function updateTotal() {
            const total = orderItems.reduce((sum, item) => sum + item.subtotal, 0);
            document.getElementById('orderTotal').textContent = total.toFixed(2);
        }

        // Al enviar el formulario, agregar items como inputs ocultos
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            if (orderItems.length === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un producto al pedido');
                return;
            }

            // Limpiar inputs previos si existen
            const existingInputs = this.querySelectorAll('input[name^="items"]');
            existingInputs.forEach(input => input.remove());

            // Agregar items al formulario
            orderItems.forEach((item, index) => {
                const productInput = document.createElement('input');
                productInput.type = 'hidden';
                productInput.name = `items[${index}][product_id]`;
                productInput.value = item.product_id;
                this.appendChild(productInput);

                const quantityInput = document.createElement('input');
                quantityInput.type = 'hidden';
                quantityInput.name = `items[${index}][quantity]`;
                quantityInput.value = item.quantity;
                this.appendChild(quantityInput);

                const priceInput = document.createElement('input');
                priceInput.type = 'hidden';
                priceInput.name = `items[${index}][price]`;
                priceInput.value = item.price;
                this.appendChild(priceInput);
            });
        });
    </script>
</x-app-layout>
