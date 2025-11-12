<x-app-layout>
    <x-slot name="header">
        Editar Pedido #{{ $order->order_number }}
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <!-- Resumen del pedido (readonly) -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Resumen del Pedido</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <span class="text-sm text-gray-600">Cliente:</span>
                            <p class="font-medium">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Fecha:</span>
                            <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Total:</span>
                            <p class="font-medium">Bs. {{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>

                    <div class="border-t pt-3">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Items:</h4>
                        <ul class="space-y-1">
                            @foreach($order->items as $item)
                                <li class="text-sm text-gray-600">
                                    {{ $item->product->name }} - {{ $item->quantity }} x Bs. {{ number_format($item->price, 2) }} = Bs. {{ number_format($item->subtotal, 2) }}
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
                            <label for="status" class="block text-sm font-medium text-gray-700">Estado *</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="pendiente" {{ old('status', $order->status) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_preparacion" {{ old('status', $order->status) == 'en_preparacion' ? 'selected' : '' }}>En Preparación</option>
                                <option value="listo" {{ old('status', $order->status) == 'listo' ? 'selected' : '' }}>Listo</option>
                                <option value="entregado" {{ old('status', $order->status) == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ old('status', $order->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notas -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notas</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-lg transition">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
