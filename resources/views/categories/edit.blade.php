<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Categoria
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-900">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('name') border-gray-500 @enderror"
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-900">Descripcion</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('description') border-gray-500 @enderror">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-900">Orden</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $category->order) }}" min="0"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('order') border-gray-500 @enderror">
                            @error('order')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-gray-700 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                                <span class="ml-2 text-sm text-gray-700">Categoria activa</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-gray-900">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                                Actualizar Categoria
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
