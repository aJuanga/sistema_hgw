<x-app-layout>
    <x-slot name="header">
        Pedidos
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <!-- Filtro de estado -->
        <form method="GET" action="{{ route('orders.index') }}" class="flex items-center gap-3">
            <label for="status" class="text-sm font-medium text-gray-700">Filtrar por estado:</label>
            <select name="status" id="status" onchange="this.form.submit()"
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Todos</option>
                <option value="pendiente" {{ request('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_preparacion" {{ request('status') == 'en_preparacion' ? 'selected' : '' }}>En Preparación</option>
                <option value="listo" {{ request('status') == 'listo' ? 'selected' : '' }}>Listo</option>
                <option value="entregado" {{ request('status') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </form>

        <!-- Botón nuevo pedido -->
        <a href="{{ route('orders.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Pedido
        </a>
    </div>

    <div>
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

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#Pedido</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @switch($order->status)
                                        @case('pendiente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pendiente
                                            </span>
                                            @break
                                        @case('en_preparacion')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                En Preparación
                                            </span>
                                            @break
                                        @case('listo')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Listo
                                            </span>
                                            @break
                                        @case('entregado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-600 text-white">
                                                Entregado
                                            </span>
                                            @break
                                        @case('cancelado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Cancelado
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    Bs. {{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                    @if($order->status == 'pendiente')
                                        <a href="{{ route('orders.edit', $order) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    @endif
                                    @if(in_array($order->status, ['pendiente', 'cancelado']))
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No hay pedidos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
