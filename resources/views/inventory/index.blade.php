<x-app-layout>
    <x-slot name="header">
        Inventario
    </x-slot>

    <div class="mb-6 flex justify-end">
        <a href="{{ route('inventory.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Producto al Inventario
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Actual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Mínimo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Máximo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($inventories as $inventory)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $inventory->product->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $inventory->current_stock }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $inventory->minimum_stock }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $inventory->maximum_stock ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $inventory->unit }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($inventory->isOutOfStock())
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            AGOTADO
                                        </span>
                                    @elseif($inventory->isLowStock())
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Stock Bajo
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            OK
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="{{ route('inventory.edit', $inventory) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    <form action="{{ route('inventory.destroy', $inventory) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No hay productos en el inventario
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $inventories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
