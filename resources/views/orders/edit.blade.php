@if(Auth::user()->isJefa() || Auth::user()->isAdmin())
<x-jefa-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.3em] bg-gradient-to-r from-emerald-600 to-amber-600 bg-clip-text text-transparent font-bold">Editar Pedido</p>
            <h1 class="text-4xl font-bold text-gray-900">Pedido #{{ $order->order_number }}</h1>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <!-- Resumen del pedido (readonly) -->
                <div class="mb-6 p-4 bg-gray-100 rounded border border-gray-300">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Resumen del Pedido</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <span class="text-sm text-gray-700">Cliente:</span>
                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-700">Fecha:</span>
                            <p class="font-medium text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-700">Total:</span>
                            <p class="font-medium text-gray-900">Bs. {{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-300 pt-3">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Items:</h4>
                        <ul class="space-y-1">
                            @foreach($order->orderItems as $item)
                                <li class="text-sm text-gray-700">
                                    {{ $item->product->name }} - {{ $item->quantity }} x Bs. {{ number_format($item->unit_price, 2) }} = Bs. {{ number_format($item->subtotal, 2) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Formulario de edición -->
                <form action="{{ route('orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Estado -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-900">Estado</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500" required>
                                <option value="pendiente" {{ old('status', $order->status) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_preparacion" {{ old('status', $order->status) == 'en_preparacion' ? 'selected' : '' }}>En Preparacion</option>
                                <option value="listo" {{ old('status', $order->status) == 'listo' ? 'selected' : '' }}>Listo</option>
                                <option value="entregado" {{ old('status', $order->status) == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ old('status', $order->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notas -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-900">Notas</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 text-sm font-medium rounded transition">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded transition">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-jefa-layout>
@else
<x-app-layout>
    <x-slot name="header">
        Editar Pedido #{{ $order->order_number }}
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <!-- Resumen del pedido (readonly) -->
                <div class="mb-6 p-4 bg-gray-100 rounded border border-gray-300">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Resumen del Pedido</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <span class="text-sm text-gray-700">Cliente:</span>
                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-700">Fecha:</span>
                            <p class="font-medium text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-700">Total:</span>
                            <p class="font-medium text-gray-900">Bs. {{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-300 pt-3">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Items:</h4>
                        <ul class="space-y-1">
                            @foreach($order->orderItems as $item)
                                <li class="text-sm text-gray-700">
                                    {{ $item->product->name }} - {{ $item->quantity }} x Bs. {{ number_format($item->unit_price, 2) }} = Bs. {{ number_format($item->subtotal, 2) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Formulario de edición -->
                <form action="{{ route('orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Estado -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-900">Estado</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500" required>
                                <option value="pendiente" {{ old('status', $order->status) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_preparacion" {{ old('status', $order->status) == 'en_preparacion' ? 'selected' : '' }}>En Preparacion</option>
                                <option value="listo" {{ old('status', $order->status) == 'listo' ? 'selected' : '' }}>Listo</option>
                                <option value="entregado" {{ old('status', $order->status) == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ old('status', $order->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notas -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-900">Notas</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 text-sm font-medium rounded transition">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded transition">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
