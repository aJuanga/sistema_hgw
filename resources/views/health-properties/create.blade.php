<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Propiedad Saludable
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('health-properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-900">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" maxlength="100"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('name') border-gray-500 @enderror"
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-900">Descripcion</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('description') border-gray-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="block text-sm font-medium text-gray-900">Imagen</label>
                            <input type="file" name="icon" id="icon" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded cursor-pointer bg-white focus:outline-none @error('icon') border-gray-500 @enderror">
                            <p class="mt-1 text-xs text-gray-600">Formato: JPG, PNG, WEBP. Maximo 2MB.</p>
                            @error('icon')
                                <p class="mt-1 text-sm text-gray-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-gray-700 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                                <span class="ml-2 text-sm text-gray-700">Propiedad activa</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('health-properties.index') }}" class="text-gray-700 hover:text-gray-900">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                                Crear Propiedad Saludable
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
