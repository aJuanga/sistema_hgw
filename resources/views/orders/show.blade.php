<x-app-layout>
    <x-slot name="header">
        Pedido #{{ $order->order_number }}
    </x-slot>

    <div class="max-w-5xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Card con información del pedido -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Cliente</h3>
                        <p class="mt-1 text-lg text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Estado</h3>
                        <div class="mt-1">
                            @switch($order->status)
                                @case('pendiente')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pendiente
                                    </span>
                                    @break
                                @case('en_preparacion')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        En Preparación
                                    </span>
                                    @break
                                @case('listo')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Listo
                                    </span>
                                    @break
                                @case('entregado')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-600 text-white">
                                        Entregado
                                    </span>
                                    @break
                                @case('cancelado')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Cancelado
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Fecha de Creación</h3>
                        <p class="mt-1 text-lg text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    @if($order->notes)
                        <div class="col-span-2">
                            <h3 class="text-sm font-medium text-gray-500">Notas</h3>
                            <p class="mt-1 text-gray-900">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabla de items del pedido -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Items del Pedido</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Unit.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $item->product->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    Bs. {{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    Bs. {{ number_format($item->subtotal, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totales -->
                <div class="mt-6 flex justify-end">
                    <div class="w-64 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="text-gray-900">Bs. {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Impuesto:</span>
                            <span class="text-gray-900">Bs. {{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold border-t pt-2">
                            <span class="text-gray-900">Total:</span>
                            <span class="text-gray-900">Bs. {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cambiar estado -->
        @if(!in_array($order->status, ['entregado', 'cancelado']))
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cambiar Estado</h3>
                    <form action="{{ route('orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="flex items-end gap-3">
                            <div class="flex-1">
                                <label for="status" class="block text-sm font-medium text-gray-700">Nuevo Estado</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="pendiente" {{ $order->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="en_preparacion" {{ $order->status == 'en_preparacion' ? 'selected' : '' }}>En Preparación</option>
                                    <option value="listo" {{ $order->status == 'listo' ? 'selected' : '' }}>Listo</option>
                                    <option value="entregado" {{ $order->status == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                    <option value="cancelado" {{ $order->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                                Actualizar Estado
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Botón volver -->
        <div class="flex justify-start">
            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Listado
            </a>
        </div>
    </div>
</x-app-layout>
