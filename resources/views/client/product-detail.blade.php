@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $product->name }} - {{ config('app.name', 'Healthy Glow Wellness') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-amber-900/95 to-orange-900/95 backdrop-blur-md border-b border-amber-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}"
                             alt="{{ $user->name }}"
                             class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-lg">
                    @else
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-amber-800 font-bold text-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif

                    <div>
                        <p class="text-lg font-bold text-white">Healthy Glow Wellness</p>
                        <p class="text-xs text-amber-100">Hola, <span class="font-semibold text-white">{{ $user->name }}</span></p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('client.dashboard') }}"
                       class="inline-flex items-center space-x-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="hidden sm:inline">Volver al Catálogo</span>
                    </a>

                    <a href="{{ route('client.cart') }}"
                       class="relative inline-flex items-center space-x-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="hidden sm:inline">Carrito</span>
                        @php
                            $cartCount = count(session()->get('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Breadcrumb -->
            <nav class="mb-8 flex items-center space-x-2 text-sm text-slate-600">
                <a href="{{ route('client.dashboard') }}" class="hover:text-amber-700 transition">Catálogo</a>
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                @if($product->category)
                    <a href="{{ route('client.dashboard', ['category' => $product->category->id]) }}" class="hover:text-amber-700 transition">
                        {{ $product->category->name }}
                    </a>
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-slate-900 font-semibold">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Product Image -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-lg overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center">
                            <svg class="w-32 h-32 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Information -->
                <div class="space-y-6">
                    <!-- Header -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            @if($product->category)
                                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-800">
                                    {{ $product->category->name }}
                                </span>
                            @endif

                            <span class="inline-flex items-center space-x-1 rounded-full {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-3 py-1">
                                <span class="h-2 w-2 rounded-full {{ $product->is_available ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></span>
                                <span class="text-sm font-semibold">{{ $product->is_available ? 'Disponible' : 'No Disponible' }}</span>
                            </span>
                        </div>

                        <h1 class="text-4xl font-black text-slate-900 mb-4">{{ $product->name }}</h1>

                        <div class="flex items-end space-x-4 mb-6">
                            <span class="text-5xl font-black text-amber-700">Bs. {{ number_format($product->price, 2) }}</span>
                            @if($product->preparation_time)
                                <span class="flex items-center space-x-1 text-slate-600 bg-slate-100 px-3 py-2 rounded-lg mb-2">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $product->preparation_time }} minutos</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    @if($product->description)
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center space-x-2">
                            <svg class="h-5 w-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Descripción</span>
                        </h2>
                        <p class="text-slate-700 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    @endif

                    <!-- Ingredients -->
                    @if($product->ingredients)
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200 p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center space-x-2">
                            <svg class="h-5 w-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Ingredientes</span>
                        </h2>
                        <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $product->ingredients }}</p>
                    </div>
                    @endif

                    <!-- Add to Cart Button -->
                    @if($product->is_available)
                        @if($product->customization_options && count($product->customization_options) > 0)
                            <button type="button"
                                    onclick="showCustomizationModal()"
                                    class="w-full inline-flex items-center justify-center space-x-2 rounded-xl bg-gradient-to-r from-amber-600 to-orange-600 px-8 py-4 text-lg font-bold text-white hover:from-amber-700 hover:to-orange-700 transition shadow-lg">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span>Agregar al Carrito</span>
                            </button>
                        @else
                            <form action="{{ route('client.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="flex items-center space-x-4 mb-4">
                                    <label for="quantity" class="text-sm font-semibold text-slate-700">Cantidad:</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="10"
                                           class="w-24 rounded-lg border border-slate-300 px-4 py-2 text-center text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                </div>
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center space-x-2 rounded-xl bg-gradient-to-r from-amber-600 to-orange-600 px-8 py-4 text-lg font-bold text-white hover:from-amber-700 hover:to-orange-700 transition shadow-lg">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    <span>Agregar al Carrito</span>
                                </button>
                            </form>
                        @endif
                    @else
                        <button disabled
                                class="w-full inline-flex items-center justify-center rounded-xl bg-slate-200 px-8 py-4 text-lg font-bold text-slate-500 cursor-not-allowed">
                            No Disponible
                        </button>
                    @endif
                </div>
            </div>

            <!-- Health Properties and Contraindications -->
            @if($product->healthProperties->count() > 0 || $product->contraindicatedDiseases->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Health Properties -->
                @if($product->healthProperties->count() > 0)
                <div class="bg-white rounded-xl border border-slate-200 shadow-lg p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center space-x-2">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Propiedades Saludables</span>
                    </h2>
                    <div class="space-y-3">
                        @foreach($product->healthProperties as $property)
                        <div class="flex items-start space-x-3 bg-green-50 rounded-lg p-3 border border-green-200">
                            <svg class="h-5 w-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $property->name }}</p>
                                @if($property->description)
                                    <p class="text-sm text-slate-600 mt-1">{{ $property->description }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Contraindications -->
                @if($product->contraindicatedDiseases->count() > 0)
                <div class="bg-white rounded-xl border border-slate-200 shadow-lg p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center space-x-2">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>Contraindicaciones</span>
                    </h2>
                    <div class="space-y-3">
                        @foreach($product->contraindicatedDiseases as $disease)
                        <div class="flex items-start space-x-3 bg-red-50 rounded-lg p-3 border border-red-200">
                            <svg class="h-5 w-5 text-red-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $disease->name }}</p>
                                @if($disease->description)
                                    <p class="text-sm text-slate-600 mt-1">{{ $disease->description }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
            <div class="bg-white rounded-xl border border-slate-200 shadow-lg p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Productos Relacionados</h2>
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                    <a href="{{ route('client.products.show', $relatedProduct) }}" class="group">
                        <article class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-amber-300 transition-all overflow-hidden">
                            <div class="relative h-40 bg-gradient-to-br from-amber-100 to-orange-100 overflow-hidden">
                                @if($relatedProduct->image)
                                    <img src="{{ asset('storage/'.$relatedProduct->image) }}"
                                         alt="{{ $relatedProduct->name }}"
                                         class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <div class="flex h-full items-center justify-center">
                                        <svg class="w-12 h-12 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-bold text-slate-900 mb-1 line-clamp-2">{{ $relatedProduct->name }}</h3>
                                <span class="text-lg font-bold text-amber-700">Bs. {{ number_format($relatedProduct->price, 2) }}</span>
                            </div>
                        </article>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white/90 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-sm text-slate-600">
                <p>&copy; {{ now()->year }} Healthy Glow Wellness. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Customization Modal (if needed) -->
    @if($product->customization_options && count($product->customization_options) > 0)
    <div id="customizationModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900">Personalizar {{ $product->name }}</h3>
                    <button type="button"
                            onclick="closeCustomizationModal()"
                            class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('client.cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">

                    <div class="space-y-4 mb-6">
                        @foreach($product->customization_options as $index => $option)
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                {{ $option['label'] ?? $option['name'] ?? 'Opción' }}
                            </label>
                            <select name="customizations[customization_{{ $product->id }}_{{ $index }}]"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 transition"
                                    required>
                                @foreach($option['options'] as $opt)
                                    @php
                                        $value = is_array($opt) ? ($opt['value'] ?? $opt) : $opt;
                                        $label = is_array($opt) ? ($opt['label'] ?? $opt) : $opt;
                                    @endphp
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex gap-3">
                        <button type="button"
                                onclick="closeCustomizationModal()"
                                class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700 transition">
                            Agregar al Carrito
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showCustomizationModal() {
            document.getElementById('customizationModal').classList.remove('hidden');
            document.getElementById('customizationModal').classList.add('flex');
        }

        function closeCustomizationModal() {
            document.getElementById('customizationModal').classList.add('hidden');
            document.getElementById('customizationModal').classList.remove('flex');
        }

        document.getElementById('customizationModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCustomizationModal();
            }
        });
    </script>
    @endif
</body>
</html>
