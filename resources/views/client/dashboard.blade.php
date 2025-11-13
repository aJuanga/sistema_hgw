@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Healthy Glow Wellness') }} - Catálogo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0f172a] text-slate-100">
    <header class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#0f172a]"></div>
        <div class="absolute inset-0 opacity-30" style="background-image: url('https://images.unsplash.com/photo-1485808191679-5f86510681a2?auto=format&fit=crop&w=1800&q=80'); background-size: cover; background-position: center;"></div>

        <div class="relative z-10">
            <nav class="max-w-7xl mx-auto px-6 lg:px-10 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-amber-300/90">Healthy Glow Wellness</p>
                    <h1 class="mt-1 text-3xl font-semibold text-white">Hola, {{ $user->name }}</h1>
                    <p class="text-sm text-slate-200/80 mt-1">Descubre bebidas plant-based, cafés artesanales y snacks funcionales, recién diseñados para equilibrar tu energía.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('client.cart') }}" class="relative inline-flex items-center rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/20">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Carrito
                        @php
                            $cartCount = count(session()->get('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 text-xs font-bold text-white">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('client.orders') }}" class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/20">
                        Mis Pedidos
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="flex">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/20"
                        >
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </nav>

            <div class="max-w-7xl mx-auto px-6 lg:px-10 pb-14">
                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Información Principal de HGW -->
                    <div class="lg:col-span-2 rounded-[32px] border border-white/10 bg-white/10 p-8 backdrop-blur shadow-2xl shadow-emerald-500/10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-16 w-16 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-2xl">
                                HGW
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.6em] text-emerald-200">Bienvenido a</p>
                                <h2 class="text-2xl font-bold text-white">Healthy Glow Wellness</h2>
                            </div>
                        </div>
                        <h3 class="text-3xl font-semibold text-white leading-tight mb-4">
                            Tu cafetería wellness en el corazón de la ciudad
                        </h3>
                        <p class="text-sm text-slate-200/85 leading-relaxed mb-6">
                            En HGW creemos que cada taza cuenta. Ofrecemos bebidas plant-based, cafés de especialidad 
                            y snacks funcionales cuidadosamente seleccionados para nutrir tu cuerpo y alma. 
                            Cada producto está diseñado pensando en tu bienestar integral.
                        </p>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="rounded-xl bg-white/10 p-4 border border-white/20">
                                <p class="text-xs text-slate-300 mb-1">Horario de Atención</p>
                                <p class="text-white font-semibold">Lun - Sáb: 8:00 - 20:00</p>
                                <p class="text-slate-400 text-xs mt-1">Domingo: Cerrado</p>
                            </div>
                            <div class="rounded-xl bg-white/10 p-4 border border-white/20">
                                <p class="text-xs text-slate-300 mb-1">Ubicación</p>
                                <p class="text-white font-semibold">Centro de la Ciudad</p>
                                <p class="text-slate-400 text-xs mt-1">Ambiente acogedor</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/20 border border-emerald-500/30 px-4 py-2 text-xs font-medium text-emerald-200">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Ingredientes Orgánicos
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-500/20 border border-amber-500/30 px-4 py-2 text-xs font-medium text-amber-200">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Preparación Artesanal
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-rose-500/20 border border-rose-500/30 px-4 py-2 text-xs font-medium text-rose-200">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Opciones Saludables
                            </span>
                        </div>
                    </div>
                    
                    <!-- Botón de Catálogo -->
                    <div class="rounded-[32px] border border-white/10 bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 p-8 backdrop-blur shadow-xl shadow-emerald-500/20 flex flex-col justify-center items-center text-center">
                        <div class="mb-6">
                            <div class="h-20 w-20 mx-auto rounded-full bg-emerald-500/30 flex items-center justify-center mb-4">
                                <svg class="h-10 w-10 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-2">Explora Nuestro Menú</h3>
                            <p class="text-sm text-slate-200/80 mb-6">
                                Descubre nuestras bebidas, cafés y snacks saludables. Personaliza tu pedido según tus preferencias.
                            </p>
                        </div>
                        <a href="#catalogo" 
                           class="w-full rounded-xl bg-emerald-500 px-6 py-4 text-center font-bold text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-600 hover:shadow-emerald-500/60 transform hover:scale-105">
                            Ver Catálogo Completo
                        </a>
                        <p class="text-xs text-slate-300 mt-4">
                            Más de 50 productos disponibles
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="relative -mt-16 pb-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <section id="catalogo" class="rounded-[30px] border border-slate-800 bg-slate-900/80 px-6 py-8 shadow-2xl shadow-emerald-500/5 backdrop-blur">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-white">Explora el menú consciente</h2>
                        <p class="text-sm text-slate-400">Filtra por ingrediente o categoría para encontrar tu próxima pausa wellness.</p>
                    </div>
                    <form method="GET" action="{{ route('client.dashboard') }}" class="flex w-full flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                        <div class="relative flex-1 min-w-[220px]">
                            <input
                                type="text"
                                name="search"
                                value="{{ $search ?? '' }}"
                                placeholder="Buscar matcha, cacao, cold brew..."
                                class="w-full rounded-2xl border border-slate-700 bg-slate-800/60 px-4 py-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-emerald-400 focus:outline-none focus:ring focus:ring-emerald-500/20"
                            >
                            <svg class="absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 103.5 9a7.5 7.5 0 0013.15 7.65z"/>
                            </svg>
                        </div>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600"
                        >
                            Buscar
                        </button>
                        @if($search)
                            <a href="{{ route('client.dashboard') }}" class="text-sm font-medium text-emerald-300 hover:text-emerald-200">Limpiar</a>
                        @endif
                    </form>
                </div>

                @if($products->count())
                    <div class="mt-10 grid gap-8 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach($products as $product)
                            <article class="group relative overflow-hidden rounded-[28px] border border-slate-800 bg-slate-900/80 shadow-lg shadow-black/20 transition hover:-translate-y-1 hover:border-emerald-500/40 hover:shadow-emerald-500/10">
                                <div class="relative h-52 overflow-hidden">
                                    @if($product->image)
                                        <img
                                            src="{{ asset('storage/'.$product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-cover transition duration-700 group-hover:scale-110 group-hover:opacity-80"
                                        >
                                    @else
                                        <div class="flex h-full items-center justify-center bg-gradient-to-br from-slate-800 via-slate-900 to-slate-800 text-xs font-semibold uppercase tracking-[0.4em] text-slate-500">
                                            HGW
                                        </div>
                                    @endif
                                    <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-900 via-slate-900/30 to-transparent"></div>
                                    <div class="absolute left-5 top-5 rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-200 backdrop-blur">
                                        {{ $product->category->name ?? 'Wellness' }}
                                    </div>
                                </div>

                                <div class="space-y-4 p-6">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">{{ $product->name }}</h3>
                                            <p class="mt-1 text-xs uppercase tracking-[0.35em] text-emerald-400">ritual diario</p>
                                        </div>
                                        <span class="rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-white shadow shadow-emerald-500/40">
                                            Bs. {{ number_format($product->price, 2) }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-slate-300 line-clamp-3">
                                        {{ $product->description ?: 'Infusión funcional con notas herbales y superfoods adaptógenos.' }}
                                    </p>

                                    <div class="flex items-center justify-between text-xs text-slate-400">
                                        <div class="inline-flex items-center gap-2">
                                            <span class="h-2.5 w-2.5 rounded-full {{ $product->is_available ? 'bg-emerald-400' : 'bg-rose-400' }}"></span>
                                            {{ $product->is_available ? 'Disponible hoy' : 'En reposición' }}
                                        </div>
                                        @if($product->preparation_time)
                                            <span>{{ $product->preparation_time }} min</span>
                                        @endif
                                    </div>

                                    <div class="pt-2 flex items-center justify-between gap-3">
                                        <a
                                            href="{{ route('products.show', $product) }}"
                                            class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-300 transition hover:text-emerald-200"
                                        >
                                            Ver detalles
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                        </a>
                                        @if($product->is_available)
                                            @if($product->customization_options && count($product->customization_options) > 0)
                                                <button
                                                    type="button"
                                                    onclick="showCustomizationModal({{ $product->id }})"
                                                    class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600"
                                                >
                                                    Personalizar y Agregar
                                                </button>
                                            @else
                                                <form action="{{ route('client.cart.add') }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600"
                                                    >
                                                        Agregar al carrito
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @else
                    <div class="mt-10 rounded-[28px] border border-dashed border-slate-700 bg-slate-900/70 p-10 text-center text-slate-400">
                        <h3 class="text-lg font-semibold text-white">Por ahora no tenemos productos disponibles.</h3>
                        <p class="mt-2 text-sm">Nuestro laboratorio sensorial está preparando nuevas recetas. Vuelve en breve.</p>
                    </div>
                @endif
            </section>
        </div>
    </main>

    <footer class="border-t border-slate-800 bg-[#0b1220]">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-8 flex flex-col gap-4 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} Healthy Glow Wellness. Café botánico y nutrición consciente.</p>
            <div class="flex flex-wrap gap-4">
                <a href="#" class="transition hover:text-emerald-300">Política de bienestar</a>
                <a href="#" class="transition hover:text-emerald-300">Términos de experiencia</a>
                <a href="mailto:soporte@healthyglow.com" class="transition hover:text-emerald-300">soporte@healthyglow.com</a>
            </div>
        </div>
    </footer>

    <!-- Modal de Personalización -->
    <div id="customizationModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-slate-900 rounded-2xl border border-slate-800 p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-semibold text-white mb-4" id="modalProductName">Personalizar Producto</h3>
            <form id="customizationForm" method="POST" action="{{ route('client.cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">
                <input type="hidden" name="quantity" value="1">
                <div id="customizationOptions" class="space-y-4 mb-6">
                    <!-- Las opciones se cargarán dinámicamente -->
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeCustomizationModal()" 
                            class="flex-1 rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white font-semibold transition hover:bg-slate-700">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="flex-1 rounded-xl bg-emerald-500 px-4 py-3 text-white font-semibold shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600">
                        Agregar al Carrito
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const products = @json($products->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'customization_options' => $p->customization_options
            ];
        }));

        function showCustomizationModal(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalProductName').textContent = 'Personalizar ' + product.name;
            
            const optionsContainer = document.getElementById('customizationOptions');
            optionsContainer.innerHTML = '';

            if (product.customization_options && product.customization_options.length > 0) {
                product.customization_options.forEach((option, index) => {
                    const div = document.createElement('div');
                    const label = option.label || option.name || 'Opción';
                    div.innerHTML = `
                        <label class="block text-sm font-medium text-slate-300 mb-2">${label}</label>
                        <select name="customizations[customization_${productId}_${index}]" 
                                class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-white text-sm focus:border-emerald-500 focus:outline-none focus:ring focus:ring-emerald-500/20"
                                required>
                            ${option.options.map(opt => {
                                const value = opt.value || opt;
                                const label = opt.label || opt;
                                return `<option value="${value}">${label}</option>`;
                            }).join('')}
                        </select>
                    `;
                    optionsContainer.appendChild(div);
                });
            }

            document.getElementById('customizationModal').classList.remove('hidden');
            document.getElementById('customizationModal').classList.add('flex');
        }

        function closeCustomizationModal() {
            document.getElementById('customizationModal').classList.add('hidden');
            document.getElementById('customizationModal').classList.remove('flex');
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('customizationModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCustomizationModal();
            }
        });
    </script>
</body>
</html>

