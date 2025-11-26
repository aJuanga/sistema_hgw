@if(Auth::user()->isJefa())
<x-jefa-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nuevo Pedido
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
</x-jefa-layout>

@elseif(Auth::user()->isAdmin())
<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nuevo Pedido
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
</x-admin-layout>

@else
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nuevo Pedido
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
                            <label for="employee_payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                Método de Pago <span class="text-red-500">*</span>
                            </label>
                            <select name="payment_method"
                                    id="employee_payment_method"
                                    onchange="handleEmployeePaymentMethodChange()"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <option value="">Seleccionar método...</option>
                                <option value="efectivo">💵 Efectivo</option>
                                <option value="qr">📱 QR (Pago Digital)</option>
                                <option value="tarjeta">💳 Tarjeta</option>
                            </select>
                        </div>

                        <!-- QR Payment Section -->
                        <div id="employee_qrPaymentSection" class="mb-6 hidden">
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border-2 border-purple-200 rounded-xl p-6">
                                <div class="text-center mb-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2">📱 Escanea el código QR para pagar</h3>
                                    <p class="text-sm text-gray-600">Usa tu aplicación bancaria para realizar el pago</p>
                                </div>

                                <div class="flex justify-center mb-4">
                                    <div class="bg-white p-4 rounded-lg shadow-lg">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=HGW_PAYMENT_QR_CODE"
                                             alt="Código QR de Pago"
                                             class="w-48 h-48">
                                    </div>
                                </div>

                                <div class="text-center text-sm text-gray-700 mb-4 bg-white p-3 rounded-lg">
                                    <p class="font-semibold text-purple-700">Cuenta: HGW S.R.L.</p>
                                    <p>Banco: Banco Nacional</p>
                                    <p>Número: 1234567890</p>
                                </div>

                                <div class="flex items-center justify-center space-x-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <span class="text-sm text-yellow-800 font-medium">Una vez realizado el pago, marca como "Pago Procesado" abajo</span>
                                </div>
                            </div>
                        </div>

                        <!-- Estado de Pago -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Procesar Pago <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <button type="button"
                                        onclick="setEmployeePaymentStatus('pendiente')"
                                        id="employee_btn_pendiente"
                                        class="employee-payment-status-btn p-4 border-2 rounded-lg text-center transition hover:shadow-lg border-orange-300 bg-orange-50">
                                    <div class="text-3xl mb-2">⏳</div>
                                    <div class="font-semibold text-gray-700">Pendiente</div>
                                    <div class="text-xs text-gray-500">Pagar después</div>
                                </button>
                                <button type="button"
                                        onclick="setEmployeePaymentStatus('pagado')"
                                        id="employee_btn_pagado"
                                        class="employee-payment-status-btn p-4 border-2 rounded-lg text-center transition hover:shadow-lg border-gray-300">
                                    <div class="text-3xl mb-2">✅</div>
                                    <div class="font-semibold text-gray-700">Pago Procesado</div>
                                    <div class="text-xs text-gray-500">Confirmar pago</div>
                                </button>
                            </div>
                            <input type="hidden" name="payment_status" id="employee_payment_status" value="pendiente" required>
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
        let productRowIndex = 1;

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

        // Manejo del método de pago para empleados
        function handleEmployeePaymentMethodChange() {
            const paymentMethod = document.getElementById('employee_payment_method').value;
            const qrSection = document.getElementById('employee_qrPaymentSection');

            if (paymentMethod === 'qr') {
                qrSection.classList.remove('hidden');
            } else {
                qrSection.classList.add('hidden');
            }
        }

        // Manejo del estado de pago para empleados
        function setEmployeePaymentStatus(status) {
            document.getElementById('employee_payment_status').value = status;

            // Actualizar estilos de botones
            const btnPendiente = document.getElementById('employee_btn_pendiente');
            const btnPagado = document.getElementById('employee_btn_pagado');

            btnPendiente.classList.remove('border-orange-500', 'bg-orange-100', 'ring-2', 'ring-orange-300');
            btnPagado.classList.remove('border-green-500', 'bg-green-100', 'ring-2', 'ring-green-300');

            btnPendiente.classList.add('border-gray-300');
            btnPagado.classList.add('border-gray-300');

            if (status === 'pendiente') {
                btnPendiente.classList.remove('border-gray-300');
                btnPendiente.classList.add('border-orange-500', 'bg-orange-100', 'ring-2', 'ring-orange-300');
            } else {
                btnPagado.classList.remove('border-gray-300');
                btnPagado.classList.add('border-green-500', 'bg-green-100', 'ring-2', 'ring-green-300');
            }
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

        // Inicializar el estado de pago
        setEmployeePaymentStatus('pendiente');
    </script>
    @endpush
</x-app-layout>
@endif
