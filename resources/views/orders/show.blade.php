<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🛒 Pedido {{ $order->order_number }}
            </h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Volver a pedidos
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Información del Pedido y Cliente -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Info del Pedido -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                        <h3 class="text-lg font-bold mb-2">Información del Pedido</h3>
                        <p class="text-sm opacity-90">Detalles generales de la orden</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Número de Orden:</span>
                            <span class="font-bold text-gray-900">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Fecha:</span>
                            <span class="font-medium text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Estado:</span>
                            @if($order->status == 'pendiente')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    ⏳ Pendiente
                                </span>
                            @elseif($order->status == 'en_preparacion')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                    👨‍🍳 En Preparación
                                </span>
                            @elseif($order->status == 'listo')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    ✅ Listo
                                </span>
                            @elseif($order->status == 'entregado')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    🎉 Entregado
                                </span>
                            @elseif($order->status == 'cancelado')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    ❌ Cancelado
                                </span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Estado de Pago:</span>
                            @if($order->payment_status == 'pagado')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                    💰 Pagado
                                </span>
                            @elseif($order->payment_status == 'pendiente')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">
                                    ⏳ Pendiente
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">
                                    ❌ Rechazado
                                </span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Método de Pago:</span>
                            <span class="font-medium text-gray-900 capitalize">{{ $order->payment_method ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info del Cliente -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-purple-500 to-pink-600 text-white">
                        <h3 class="text-lg font-bold mb-2">Información del Cliente</h3>
                        <p class="text-sm opacity-90">Datos de contacto y entrega</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                                {{ substr($order->user->name, 0, 2) }}
                            </div>
                            <div class="ml-4">
                                <div class="font-bold text-gray-900 text-lg">{{ $order->user->name }}</div>
                                <div class="text-sm text-gray-600">{{ $order->user->email }}</div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-2">📍 Dirección de Entrega:</p>
                            <p class="font-medium text-gray-900">{{ $order->delivery_address ?? 'No especificada' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-2">📞 Teléfono de Contacto:</p>
                            <p class="font-medium text-gray-900">{{ $order->delivery_phone ?? 'No especificado' }}</p>
                        </div>
                        @if($order->notes)
                            <div>
                                <p class="text-sm text-gray-600 mb-2">📝 Notas:</p>
                                <p class="font-medium text-gray-700 italic">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Productos del Pedido -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-orange-500 to-red-600 text-white">
                    <h3 class="text-lg font-bold">🍽️ Productos del Pedido</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Producto
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Precio Unit.
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cantidad
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center text-white font-bold">
                                                    {{ substr($item->product->name, 0, 2) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $item->product->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $item->product->category->name ?? 'Sin categoría' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                            Bs {{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-3 py-1 inline-flex text-sm font-bold rounded-full bg-blue-100 text-blue-800">
                                                x{{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900">
                                            Bs {{ number_format($item->subtotal, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totales -->
                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium text-gray-900">Bs {{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Impuesto (13%):</span>
                                <span class="font-medium text-gray-900">Bs {{ number_format($order->tax, 2) }}</span>
                            </div>
                            @if($order->delivery_fee > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Costo de Envío:</span>
                                    <span class="font-medium text-gray-900">Bs {{ number_format($order->delivery_fee, 2) }}</span>
                                </div>
                            @endif
                            @if($order->discount > 0)
                                <div class="flex justify-between text-sm text-green-600">
                                    <span>Descuento:</span>
                                    <span class="font-medium">- Bs {{ number_format($order->discount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-lg font-bold border-t border-gray-300 pt-2 mt-2">
                                <span class="text-gray-900">TOTAL:</span>
                                <span class="text-green-600">Bs {{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('orders.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Volver
                </a>
                <a href="{{ route('orders.edit', $order->id) }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    ✏️ Editar Pedido
                </a>
            </div>
        </div>
    </div>
</x-app-layout>