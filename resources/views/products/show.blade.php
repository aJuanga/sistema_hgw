<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle del Producto
            </h2>
            <div class="space-x-2">
                <a href="{{ route('products.edit', $product) }}" 
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('products.index') }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Imagen -->
                        <div>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                    alt="{{ $product->name }}" 
                                    class="w-full h-64 object-cover rounded-lg shadow">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400">Sin imagen</span>
                                </div>
                            @endif
                        </div>

                        <!-- Información básica -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $product->slug }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Categoría:</span>
                                <p class="text-lg text-gray-900">{{ $product->category->name ?? 'Sin categoría' }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Precio:</span>
                                <p class="text-2xl font-bold text-green-600">Bs. {{ number_format($product->price, 2) }}</p>
                            </div>

                            @if($product->preparation_time)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Tiempo de preparación:</span>
                                    <p class="text-lg text-gray-900">{{ $product->preparation_time }} minutos</p>
                                </div>
                            @endif

                            <div class="flex space-x-2">
                                @if($product->is_available)
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm font-semibold">
                                        Disponible
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-sm font-semibold">
                                        No disponible
                                    </span>
                                @endif

                                @if($product->is_featured)
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-semibold">
                                        ⭐ Destacado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    @if($product->description)
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Descripción</h4>
                            <p class="text-gray-700">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Ingredientes -->
                    @if($product->ingredients)
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Ingredientes</h4>
                            <p class="text-gray-700">{{ $product->ingredients }}</p>
                        </div>
                    @endif

                    <!-- Propiedades saludables -->
                    @if($product->healthProperties->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Propiedades Saludables</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->healthProperties as $property)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                        {{ $property->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Contraindicaciones -->
                    @if($product->contraindicatedDiseases->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Contraindicaciones</h4>
                            <div class="space-y-2">
                                @foreach($product->contraindicatedDiseases as $disease)
                                    <div class="bg-red-50 border border-red-200 rounded p-3">
                                        <p class="font-semibold text-red-800">{{ $disease->name }}</p>
                                        @if($disease->pivot->reason)
                                            <p class="text-sm text-red-700 mt-1">{{ $disease->pivot->reason }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Metadatos -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-500">
                            <div>
                                <span class="font-medium">Creado:</span> {{ $product->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div>
                                <span class="font-medium">Actualizado:</span> {{ $product->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>