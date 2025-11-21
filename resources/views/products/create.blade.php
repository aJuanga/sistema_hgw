<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div class="col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Categoría -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría *</label>
                                <select name="category_id" id="category_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Precio -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Precio (Bs.) *</label>
                                <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tiempo de preparación -->
                            <div>
                                <label for="preparation_time" class="block text-sm font-medium text-gray-700">Tiempo preparación (min)</label>
                                <input type="number" name="preparation_time" id="preparation_time" value="{{ old('preparation_time') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('preparation_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Imagen -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Imagen</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea name="description" id="description" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ingredientes -->
                            <div class="col-span-2">
                                <label for="ingredients" class="block text-sm font-medium text-gray-700">Ingredientes</label>
                                <textarea name="ingredients" id="ingredients" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('ingredients') }}</textarea>
                                @error('ingredients')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Propiedades Saludables -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Propiedades Saludables</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-40 overflow-y-auto p-3 border border-gray-300 rounded-md bg-gray-50">
                                    @forelse($healthProperties as $property)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="health_properties[]" value="{{ $property->id }}"
                                                id="health_property_{{ $property->id }}"
                                                {{ in_array($property->id, old('health_properties', [])) ? 'checked' : '' }}
                                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                            <label for="health_property_{{ $property->id }}" class="ml-2 text-sm text-gray-700">
                                                {{ $property->name }}
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500 col-span-3">No hay propiedades saludables disponibles</p>
                                    @endforelse
                                </div>
                                @error('health_properties')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Enfermedades Contraindicadas -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contraindicado para (Enfermedades)</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-40 overflow-y-auto p-3 border border-gray-300 rounded-md bg-gray-50">
                                    @forelse($diseases as $disease)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="diseases[]" value="{{ $disease->id }}"
                                                id="disease_{{ $disease->id }}"
                                                {{ in_array($disease->id, old('diseases', [])) ? 'checked' : '' }}
                                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                            <label for="disease_{{ $disease->id }}" class="ml-2 text-sm text-gray-700">
                                                {{ $disease->name }}
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500 col-span-3">No hay enfermedades disponibles</p>
                                    @endforelse
                                </div>
                                @error('diseases')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Checkboxes -->
                            <div class="col-span-2 space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_available" id="is_available" value="1"
                                        {{ old('is_available', true) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_available" class="ml-2 block text-sm text-gray-900">
                                        Disponible para venta
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                        {{ old('is_featured') ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                        Producto destacado
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('products.index') }}" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>