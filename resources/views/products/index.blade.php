<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-sm uppercase tracking-[0.4em] text-emerald-400">Gestión de menú</p>
            <h1 class="text-3xl font-semibold text-slate-900">Productos saludables</h1>
            <p class="text-sm text-slate-500">Administra las bebidas energéticas, batidos y snacks de tu cafetería wellness.</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <section class="relative mb-10 overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-amber-400 px-10 py-12 text-white shadow-xl">
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=1800&q=80'); background-size: cover; background-position: center;"></div>
        <div class="relative z-10 grid gap-6 lg:grid-cols-2 lg:items-center">
            <div class="space-y-4">
                <h2 class="text-4xl font-bold leading-tight">Diseña experiencias wellness</h2>
                <p class="text-white/85 text-sm lg:text-base">
                    Presenta tus bebidas funcionales con fotografías cálidas y descripciones que resalten ingredientes naturales, beneficios y maridajes sugeridos.
                </p>
                <div class="flex items-center gap-3 text-sm text-white/80">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-5 py-2">
                        <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                        Recetas sin azúcar refinada
                    </div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-5 py-2">
                        <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                        Ingredientes orgánicos
                    </div>
                </div>
            </div>
            <div class="relative hidden justify-end lg:flex">
                <div class="rounded-2xl bg-white/15 px-6 py-5 backdrop-blur">
                    <p class="text-sm uppercase tracking-[0.3em] text-white/70">recomendación</p>
                    <h3 class="mt-2 text-2xl font-semibold">Mantén coherencia visual</h3>
                    <p class="mt-2 text-white/85 text-sm leading-relaxed">
                        Usa fondos cálidos, props naturales y una iluminación suave para crear identidad wellness y apetito visual.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <form method="GET" class="flex flex-1 flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[220px]">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Buscar por nombre, ingrediente o categoría..."
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring focus:ring-emerald-100"
                >
                <svg class="absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 103.5 9a7.5 7.5 0 0013.15 7.65z"/>
                </svg>
            </div>

            <div class="relative">
                <select
                    name="status"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring focus:ring-emerald-100"
                >
                    <option value="">Estado</option>
                    <option value="available" @selected($status === 'available')>Disponible</option>
                    <option value="unavailable" @selected($status === 'unavailable')>No disponible</option>
                </select>
            </div>

            <button
                type="submit"
                class="inline-flex items-center rounded-xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 transition hover:bg-emerald-600"
            >
                Filtrar
            </button>

            @if($search || $status)
                <a href="{{ route('products.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
                    Limpiar filtros
                </a>
            @endif
        </form>

        @if(Auth::user()->isJefa())
            <a
                href="{{ route('products.create') }}"
                class="inline-flex items-center justify-center rounded-xl border border-transparent bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-xl shadow-slate-900/30 transition hover:bg-slate-800"
            >
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo producto
            </a>
        @endif
    </section>

    @if($products->isEmpty())
        <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-10 text-center shadow-sm">
            <h3 class="text-lg font-semibold text-slate-700">Aún no tienes productos cargados</h3>
            <p class="mt-2 text-sm text-slate-500">Empieza creando tus bebidas estrella para que tu catálogo cobre vida.</p>
            @if(Auth::user()->isJefa())
                <a href="{{ route('products.create') }}" class="mt-5 inline-flex items-center rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-600">
                    Crear el primero
                </a>
            @endif
        </div>
    @else
        <div class="grid gap-6 lg:grid-cols-3 md:grid-cols-2">
            @foreach($products as $product)
                <article class="group relative overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative h-48 overflow-hidden">
                        @if($product->image && file_exists(storage_path('app/public/'.$product->image)))
                            <img
                                src="{{ asset('storage/'.$product->image) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-slate-100 via-emerald-50 to-amber-50 text-sm font-semibold uppercase text-slate-400 tracking-[0.3em]">
                                HGW
                            </div>
                        @endif
                        @if($product->is_featured)
                            <div class="absolute left-4 top-4 rounded-full bg-amber-400/95 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-900">
                                Destacado
                            </div>
                        @endif
                    </div>

                    <div class="space-y-4 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-emerald-500">
                                    {{ $product->category->name ?? 'Sin categoría' }}
                                </p>
                                <h3 class="mt-2 text-lg font-semibold text-slate-900">
                                    {{ $product->name }}
                                </h3>
                            </div>
                            <span class="rounded-full bg-slate-900 px-3 py-1 text-xs font-semibold text-white shadow">
                                Bs. {{ number_format($product->price, 2) }}
                            </span>
                        </div>

                        @if($product->ingredients)
                            <p class="text-sm text-slate-500 line-clamp-2">
                                {{ $product->ingredients }}
                            </p>
                        @else
                            <p class="text-sm text-slate-400 italic">Describe ingredientes clave y beneficios.</p>
                        @endif

                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-2.5 w-2.5 rounded-full {{ $product->is_available ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                <span class="text-xs font-semibold uppercase tracking-wide {{ $product->is_available ? 'text-emerald-600' : 'text-rose-500' }}">
                                    {{ $product->is_available ? 'Disponible' : 'No disponible' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-3 text-xs font-medium text-slate-500">
                                @if($product->preparation_time)
                                    <span>{{ $product->preparation_time }} min</span>
                                @endif
                                <span>{{ $product->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-2">
                            <a href="{{ route('products.show', $product) }}"
                               class="{{ Auth::user()->isJefa() ? 'flex-1' : 'w-full' }} inline-flex items-center justify-center rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-700">
                                Ver ficha
                            </a>
                            @if(Auth::user()->isJefa())
                                <a href="{{ route('products.edit', $product) }}"
                                   class="flex-1 inline-flex items-center justify-center rounded-2xl border border-transparent bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600">
                                    Editar
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')" class="flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl border border-transparent bg-rose-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-600">
                                        Borrar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @endif
</x-app-layout>