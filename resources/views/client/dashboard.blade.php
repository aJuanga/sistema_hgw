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
                <form method="POST" action="{{ route('logout') }}" class="flex">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/20"
                    >
                        Cerrar sesión
                    </button>
                </form>
            </nav>

            <div class="max-w-7xl mx-auto px-6 lg:px-10 pb-14">
                <div class="grid gap-8 lg:grid-cols-[1.6fr,1fr]">
                    <div class="rounded-[32px] border border-white/10 bg-white/10 p-8 backdrop-blur shadow-2xl shadow-emerald-500/10">
                        <p class="text-xs uppercase tracking-[0.6em] text-emerald-200">Colección signature</p>
                        <h2 class="mt-4 text-4xl font-semibold text-white leading-tight">
                            Bebidas sensoriales con café orgánico, leches vegetales y superfoods
                        </h2>
                        <p class="mt-4 text-sm text-slate-200/85 leading-relaxed">
                            Aromas a cacao tostado, notas de cardamomo y texturas cremosas listas para reconfortarte.
                            Filtra por categoría o ingrediente y crea tu pedido consciente.
                        </p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-xs font-medium tracking-wide text-white">
                                <span class="h-2 w-2 rounded-full bg-emerald-300"></span> Detox & Glow
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-xs font-medium tracking-wide text-white">
                                <span class="h-2 w-2 rounded-full bg-amber-300"></span> Café de especialidad
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-xs font-medium tracking-wide text-white">
                                <span class="h-2 w-2 rounded-full bg-rose-300"></span> Snacks plant-based
                            </span>
                        </div>
                    </div>
                    <div class="rounded-[32px] border border-white/10 bg-white/10 p-6 backdrop-blur shadow-xl shadow-amber-500/10 flex flex-col justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.4em] text-amber-200">Tip de la barista</p>
                            <h3 class="mt-3 text-2xl font-semibold text-white">Activa tus sentidos</h3>
                            <p class="mt-3 text-sm text-slate-200/80 leading-relaxed">
                                Combina nuestros cold brews con toppings de nueces activadas y flores comestibles para dar textura y aroma.
                            </p>
                        </div>
                        <div class="mt-6 rounded-3xl bg-white/10 p-4 text-xs text-slate-200/70">
                            <p class="uppercase tracking-[0.3em] text-emerald-200">horario</p>
                            <p class="mt-1 font-medium text-white">Lunes a sábado · 08:00 - 20:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="relative -mt-16 pb-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <section class="rounded-[30px] border border-slate-800 bg-slate-900/80 px-6 py-8 shadow-2xl shadow-emerald-500/5 backdrop-blur">
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

                                    <div class="pt-2">
                                        <a
                                            href="{{ route('products.show', $product) }}"
                                            class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-300 transition hover:text-emerald-200"
                                        >
                                            Ver detalles sensoriales
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                        </a>
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
</body>
</html>

