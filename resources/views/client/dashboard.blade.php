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
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-amber-800" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-white">Healthy Glow Wellness</p>
                        <p class="text-xs text-amber-100">Hola, <span class="font-semibold text-white">{{ $user->name }}</span></p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
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

                    <a href="{{ route('client.orders') }}"
                       class="inline-flex items-center space-x-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="hidden sm:inline">Mis Pedidos</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center space-x-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Stats -->
    <header class="pt-20 pb-8 bg-gradient-to-br from-amber-100 via-orange-100 to-yellow-100 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-black text-amber-900 mb-2">Catálogo de Productos</h1>
                <p class="text-base text-amber-700 font-medium">Descubre nuestros productos saludables</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white rounded-xl border border-amber-200 shadow-sm p-6 text-center">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="h-6 w-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">{{ $stats['totalOrders'] }}</p>
                    <p class="text-xs font-medium text-slate-600">Pedidos</p>
                </div>

                <div class="bg-white rounded-xl border border-amber-200 shadow-sm p-6 text-center">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="h-6 w-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">Bs. {{ number_format($stats['totalSpent'], 2) }}</p>
                    <p class="text-xs font-medium text-slate-600">Gastado</p>
                </div>

                <div class="bg-white rounded-xl border border-amber-200 shadow-sm p-6 text-center">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="h-6 w-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">{{ $stats['loyaltyPoints'] }}</p>
                    <p class="text-xs font-medium text-slate-600">Puntos</p>
                </div>

                <div class="bg-white rounded-xl border border-amber-200 shadow-sm p-6 text-center">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="h-6 w-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">{{ $stats['pendingOrders'] }}</p>
                    <p class="text-xs font-medium text-slate-600">Pendientes</p>
                </div>

                <div class="bg-white rounded-xl border border-amber-200 shadow-sm p-6 text-center">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="h-6 w-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mb-1">{{ $stats['completedOrders'] }}</p>
                    <p class="text-xs font-medium text-slate-600">Completados</p>
                </div>
            </div>

            <!-- Recent Orders -->
            @if($recentOrders->count() > 0)
            <div class="mt-8 bg-white rounded-xl border border-amber-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Pedidos Recientes</h3>
                    <a href="{{ route('client.orders') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-800 transition">
                        Ver todos
                    </a>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach($recentOrders as $order)
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-slate-900">#{{ $order->order_number }}</span>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                {{ $order->status === 'completed' || $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'pending' || $order->status === 'processing' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mb-2">{{ $order->orderItems->count() }} productos</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-slate-900">Bs. {{ number_format($order->total, 2) }}</span>
                            <span class="text-xs text-slate-500">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </header>

    <!-- Main Content with Background Image -->
    <main class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Imagen de fondo semitransparente -->
        <div class="fixed inset-0 z-0 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50"></div>
            <img src="{{ asset('images/1.jpg') }}"
                 alt="Background"
                 class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-white/40 backdrop-blur-sm"></div>
        </div>

        <!-- Contenido con posición relativa -->
        <div class="relative z-10">

        <!-- Search and Filters -->
        <section class="mb-8">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">Nuestros Productos</h2>
                        <p class="text-sm text-slate-600">
                            @if($selectedCategory)
                                Categoría: <span class="font-semibold text-amber-700">{{ $selectedCategory->name }}</span>
                            @elseif($search)
                                Resultados para: <span class="font-semibold text-amber-700">"{{ $search }}"</span>
                            @else
                                Explora nuestro catálogo completo
                            @endif
                        </p>
                    </div>

                    <form method="GET" action="{{ route('client.dashboard') }}" class="flex flex-col sm:flex-row gap-3">
                        <input type="hidden" name="category" value="{{ $categoryId ?? '' }}">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ $search ?? '' }}"
                                   placeholder="Buscar productos..."
                                   class="w-full sm:w-80 rounded-lg border border-slate-300 bg-white px-4 py-2 pl-10 text-sm text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 transition">
                            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <button type="submit"
                                class="inline-flex items-center justify-center space-x-2 rounded-lg bg-amber-600 px-6 py-2 text-sm font-semibold text-white hover:bg-amber-700 transition">
                            <span>Buscar</span>
                        </button>
                        @if($search || $categoryId)
                            <a href="{{ route('client.dashboard') }}"
                               class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                                Limpiar
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Categories Filter -->
                @if($categories->count() > 0)
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <p class="text-sm font-semibold text-slate-700 mb-3">Categorías:</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('client.dashboard') }}"
                           class="inline-flex items-center rounded-lg border {{ !$categoryId ? 'border-amber-600 bg-amber-50 text-amber-800' : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-50' }} px-4 py-2 text-sm font-semibold transition">
                            Todas
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('client.dashboard', ['category' => $category->id]) }}"
                           class="inline-flex items-center space-x-2 rounded-lg border {{ $categoryId == $category->id ? 'border-amber-600 bg-amber-50 text-amber-800' : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-50' }} px-4 py-2 text-sm font-semibold transition">
                            <span>{{ $category->name }}</span>
                            <span class="text-xs {{ $categoryId == $category->id ? 'text-amber-600' : 'text-slate-500' }}">({{ $category->products_count }})</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </section>

        <!-- Products Grid -->
        @if($products->count())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-8">
                @foreach($products as $product)
                    <article class="group bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-amber-300 transition-all overflow-hidden flex flex-col h-full">
                        <!-- Image Container - Fixed Height -->
                        <div class="relative h-48 bg-gradient-to-br from-amber-100 to-orange-100 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                            @else
                                <div class="flex h-full items-center justify-center">
                                    <svg class="w-16 h-16 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute left-3 top-3">
                                <span class="inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-semibold text-slate-900 shadow">
                                    {{ $product->category->name ?? 'Wellness' }}
                                </span>
                            </div>

                            <!-- Availability Badge -->
                            <div class="absolute right-3 top-3">
                                <span class="inline-flex items-center space-x-1 rounded-full {{ $product->is_available ? 'bg-green-500' : 'bg-red-500' }} px-3 py-1 shadow">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white {{ $product->is_available ? 'animate-pulse' : '' }}"></span>
                                    <span class="text-xs font-semibold text-white">{{ $product->is_available ? 'Disponible' : 'Agotado' }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Content Container - Flex Grow -->
                        <div class="flex flex-col flex-grow p-4">
                            <div class="flex-grow">
                                <h3 class="text-base font-bold text-slate-900 mb-1 line-clamp-1">{{ $product->name }}</h3>
                                <p class="text-xs text-slate-600 mb-3 line-clamp-2">
                                    {{ $product->description ?: 'Producto premium con ingredientes naturales.' }}
                                </p>
                            </div>

                            <!-- Price and Time -->
                            <div class="flex items-center justify-between mb-4 pb-4 border-t border-slate-200 pt-4">
                                <span class="text-2xl font-bold text-amber-700">Bs. {{ number_format($product->price, 2) }}</span>
                                @if($product->preparation_time)
                                    <span class="flex items-center space-x-1 text-xs text-slate-600 font-medium bg-slate-100 px-2 py-1 rounded">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $product->preparation_time }} min</span>
                                    </span>
                                @endif
                            </div>

                            <!-- Actions - Fixed Height -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('products.show', $product) }}"
                                   class="flex-1 inline-flex items-center justify-center space-x-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>Ver</span>
                                </a>

                                @if($product->is_available)
                                    @if($product->customization_options && count($product->customization_options) > 0)
                                        <button type="button"
                                                onclick="showCustomizationModal({{ $product->id }})"
                                                class="flex-1 inline-flex items-center justify-center space-x-1 rounded-lg bg-amber-600 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-700 transition">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            <span>Agregar</span>
                                        </button>
                                    @else
                                        <form action="{{ route('client.cart.add') }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"
                                                    class="w-full inline-flex items-center justify-center space-x-1 rounded-lg bg-amber-600 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-700 transition">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                <span>Agregar</span>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <button disabled
                                            class="flex-1 inline-flex items-center justify-center rounded-lg bg-slate-200 px-3 py-2 text-sm font-semibold text-slate-500 cursor-not-allowed">
                                        No disponible
                                    </button>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">No se encontraron productos</h3>
                <p class="text-sm text-slate-600 mb-4">Intenta con otros términos de búsqueda o explora otras categorías.</p>
                <a href="{{ route('client.dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-amber-600 px-6 py-2 text-sm font-semibold text-white hover:bg-amber-700 transition">
                    Ver todos los productos
                </a>
            </div>
        @endif

        </div><!-- Cierre del contenido relativo -->
    </main>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-slate-200 bg-white/90 backdrop-blur-sm mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-sm text-slate-600">
                <p>&copy; {{ now()->year }} Healthy Glow Wellness. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Customization Modal -->
    <div id="customizationModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900" id="modalProductName">Personalizar Producto</h3>
                    <button type="button"
                            onclick="closeCustomizationModal()"
                            class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form id="customizationForm" method="POST" action="{{ route('client.cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" id="modalProductId">
                    <input type="hidden" name="quantity" value="1">

                    <div id="customizationOptions" class="space-y-4 mb-6">
                        <!-- Opciones dinámicas -->
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
                        <label class="block text-sm font-semibold text-slate-900 mb-2">${label}</label>
                        <select name="customizations[customization_${productId}_${index}]"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 transition"
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
