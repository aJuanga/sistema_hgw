<x-app-layout>
    <x-slot name="header">
        Categorias
    </x-slot>

    <div class="mb-6 flex justify-end">
        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Categoria
        </a>
    </div>

    <div>
            @if(session('success'))
                <div class="bg-gray-100 border border-gray-400 text-gray-900 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-gray-100 border border-gray-400 text-gray-900 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Imagen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Slug</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Productos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($category->icon)
                                            <img src="{{ asset('storage/'.$category->icon) }}" alt="{{ $category->name }}" class="h-12 w-12 object-cover rounded">
                                        @else
                                            <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-400 text-xs">Sin imagen</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                        <div class="text-xs text-gray-500">Orden: {{ $category->order }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $category->products_count }} productos
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($category->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-gray-200 text-gray-900">
                                                Activa
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-gray-300 text-gray-700">
                                                Inactiva
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium space-x-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="text-gray-700 hover:text-gray-900">Editar</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Estas seguro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-700 hover:text-gray-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No hay categorias registradas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
