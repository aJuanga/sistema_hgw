@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Healthy Glow Wellness') }} - Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-slide-up {
            animation: slideInUp 0.6s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.5s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }

        .stat-card {
            opacity: 0;
            animation: slideInUp 0.6s ease-out forwards;
        }

        .product-card {
            opacity: 0;
            animation: fadeIn 0.6s ease-out forwards;
        }

        /* Gradient Background Animation */
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .animated-gradient {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #0f172a, #334155);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100" x-data="dashboardApp()">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-xl bg-slate-950/80 border-b border-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/50">
                        HGW
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-emerald-400 font-semibold">Healthy Glow</p>
                        <p class="text-sm text-slate-400 -mt-0.5">Wellness</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('client.cart') }}"
                       class="relative inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-slate-700/50 hover:border-emerald-500/50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="hidden sm:inline">Carrito</span>
                        @php
                            $cartCount = count(session()->get('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 text-xs font-bold text-white shadow-lg shadow-emerald-500/50">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('client.orders') }}"
                       class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-slate-700/50 hover:border-emerald-500/50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="hidden sm:inline">Pedidos</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-rose-500/20 hover:border-rose-500/50 hover:text-rose-300">
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

    <!-- Hero Section -->
    <header class="relative overflow-hidden pt-16 animated-gradient">
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1485808191679-5f86510681a2?auto=format&fit=crop&w=1800&q=80'); background-size: cover; background-position: center;"></div>

        <!-- Decorative Elements -->
        <div class="absolute top-20 right-10 h-72 w-72 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="absolute bottom-10 left-10 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8 animate-slide-up">
                <p class="text-sm uppercase tracking-[0.3em] text-emerald-400 font-semibold mb-2">Tu espacio wellness</p>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-4">
                    Hola, <span class="bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent">{{ $user->name }}</span>
                </h1>
                <p class="text-lg text-slate-300 max-w-2xl mx-auto">
                    Descubre bebidas plant-based, cafés artesanales y snacks funcionales diseñados para tu bienestar
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="stat-card delay-100 rounded-2xl border border-slate-700/50 bg-slate-900/80 backdrop-blur-xl p-6 text-center transform transition-all duration-300 hover:scale-105 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-500/20">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 mb-3 shadow-lg shadow-emerald-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $stats['totalOrders'] }}</p>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Pedidos Totales</p>
                </div>

                <div class="stat-card delay-200 rounded-2xl border border-slate-700/50 bg-slate-900/80 backdrop-blur-xl p-6 text-center transform transition-all duration-300 hover:scale-105 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/20">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 mb-3 shadow-lg shadow-blue-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">Bs. {{ number_format($stats['totalSpent'], 2) }}</p>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Total Gastado</p>
                </div>

                <div class="stat-card delay-300 rounded-2xl border border-slate-700/50 bg-slate-900/80 backdrop-blur-xl p-6 text-center transform transition-all duration-300 hover:scale-105 hover:border-amber-500/50 hover:shadow-lg hover:shadow-amber-500/20">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 mb-3 shadow-lg shadow-amber-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $stats['loyaltyPoints'] }}</p>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Puntos</p>
                </div>

                <div class="stat-card delay-400 rounded-2xl border border-slate-700/50 bg-slate-900/80 backdrop-blur-xl p-6 text-center transform transition-all duration-300 hover:scale-105 hover:border-orange-500/50 hover:shadow-lg hover:shadow-orange-500/20">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 mb-3 shadow-lg shadow-orange-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $stats['pendingOrders'] }}</p>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Pendientes</p>
                </div>

                <div class="stat-card delay-100 rounded-2xl border border-slate-700/50 bg-slate-900/80 backdrop-blur-xl p-6 text-center transform transition-all duration-300 hover:scale-105 hover:border-green-500/50 hover:shadow-lg hover:shadow-green-500/20">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 mb-3 shadow-lg shadow-green-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $stats['completedOrders'] }}</p>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Completados</p>
                </div>
            </div>

            <!-- Recent Orders Section -->
            @if($recentOrders->count() > 0)
            <div class="animate-fade-in delay-200 rounded-2xl border border-slate-700/50 bg-slate-900/60 backdrop-blur-xl p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Pedidos Recientes</h3>
                    <a href="{{ route('client.orders') }}" class="text-sm font-medium text-emerald-400 hover:text-emerald-300 transition">
                        Ver todos →
                    </a>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach($recentOrders as $order)
                    <div class="rounded-xl border border-slate-700/50 bg-slate-800/50 p-4 transition hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-500/10">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-emerald-400">#{{ $order->order_number }}</span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                {{ $order->status === 'completed' || $order->status === 'delivered' ? 'bg-green-500/20 text-green-400' : '' }}
                                {{ $order->status === 'pending' || $order->status === 'processing' ? 'bg-orange-500/20 text-orange-400' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-rose-500/20 text-rose-400' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-300 mb-2">{{ $order->orderItems->count() }} productos</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-white">Bs. {{ number_format($order->total, 2) }}</span>
                            <span class="text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative bg-slate-950 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- Search and Filter Section -->
            <section class="mb-10 animate-scale-in">
                <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">Explora nuestro menú wellness</h2>
                            <p class="text-sm text-slate-400">Encuentra tu próxima pausa consciente</p>
                        </div>

                        <form method="GET" action="{{ route('client.dashboard') }}" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                            <div class="relative flex-1 lg:min-w-[300px]">
                                <input type="text"
                                       name="search"
                                       value="{{ $search ?? '' }}"
                                       placeholder="Buscar matcha, cacao, cold brew..."
                                       class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-3 pl-11 text-sm text-slate-100 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                                <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <button type="submit"
                                    class="inline-flex items-center justify-center space-x-2 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span>Buscar</span>
                            </button>
                            @if($search)
                                <a href="{{ route('client.dashboard') }}"
                                   class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-800/50 px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-slate-700/50 hover:text-white">
                                    Limpiar
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Category Filter -->
                    @if($categories->count() > 0)
                    <div class="mt-6 flex flex-wrap gap-2">
                        <span class="text-sm text-slate-400 font-medium mr-2">Categorías:</span>
                        @foreach($categories as $category)
                        <button class="inline-flex items-center space-x-1.5 rounded-full border border-slate-700 bg-slate-800/50 px-4 py-1.5 text-xs font-medium text-slate-300 transition hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:text-emerald-300">
                            <span>{{ $category->name }}</span>
                            <span class="text-slate-500">({{ $category->products_count }})</span>
                        </button>
                        @endforeach>
                    </div>
                    @endif
                </div>
            </section>

            <!-- Products Grid -->
            @if($products->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-10">
                    @foreach($products as $index => $product)
                        <article class="product-card group relative overflow-hidden rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl shadow-xl transition-all duration-300 hover:-translate-y-2 hover:border-emerald-500/50 hover:shadow-2xl hover:shadow-emerald-500/20"
                                 style="animation-delay: {{ ($index % 4) * 0.1 }}s">
                            <!-- Image -->
                            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                                @else
                                    <div class="flex h-full items-center justify-center">
                                        <span class="text-4xl font-bold text-slate-700">HGW</span>
                                    </div>
                                @endif

                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/30 to-transparent"></div>

                                <!-- Category Badge -->
                                <div class="absolute left-3 top-3">
                                    <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 backdrop-blur-xl px-3 py-1 text-xs font-semibold text-white">
                                        {{ $product->category->name ?? 'Wellness' }}
                                    </span>
                                </div>

                                <!-- Availability Badge -->
                                <div class="absolute right-3 top-3">
                                    <span class="inline-flex items-center space-x-1 rounded-full {{ $product->is_available ? 'bg-green-500/90' : 'bg-rose-500/90' }} px-2 py-1">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $product->is_available ? 'bg-white' : 'bg-white' }}"></span>
                                        <span class="text-xs font-medium text-white">{{ $product->is_available ? 'Disponible' : 'Agotado' }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 space-y-4">
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1 line-clamp-1">{{ $product->name }}</h3>
                                    <p class="text-xs uppercase tracking-wider text-emerald-400 font-medium">Ritual diario</p>
                                </div>

                                <p class="text-sm text-slate-400 line-clamp-2">
                                    {{ $product->description ?: 'Producto premium con ingredientes naturales seleccionados.' }}
                                </p>

                                <!-- Price and Time -->
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-white">Bs. {{ number_format($product->price, 2) }}</span>
                                    @if($product->preparation_time)
                                        <span class="flex items-center space-x-1 text-xs text-slate-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $product->preparation_time }} min</span>
                                        </span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-2 pt-2">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="flex-1 inline-flex items-center justify-center space-x-1 rounded-xl border border-slate-700 bg-slate-800/50 px-4 py-2.5 text-sm font-medium text-slate-200 transition hover:bg-slate-700/50 hover:border-emerald-500/50 hover:text-emerald-300">
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
                                                    class="flex-1 inline-flex items-center justify-center space-x-1 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/50 hover:scale-105">
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
                                                        class="w-full inline-flex items-center justify-center space-x-1 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/50 hover:scale-105">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                    <span>Agregar</span>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10 animate-fade-in">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/50 backdrop-blur-xl p-12 text-center animate-fade-in">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-800/50 mb-4">
                        <svg class="h-8 w-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No hay productos disponibles</h3>
                    <p class="text-sm text-slate-400">Nuestro laboratorio sensorial está preparando nuevas recetas. Vuelve pronto.</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800/50 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-500">
                <p>&copy; {{ now()->year }} Healthy Glow Wellness. Café botánico y nutrición consciente.</p>
                <div class="flex flex-wrap gap-6">
                    <a href="#" class="transition hover:text-emerald-400">Política de bienestar</a>
                    <a href="#" class="transition hover:text-emerald-400">Términos</a>
                    <a href="mailto:soporte@healthyglow.com" class="transition hover:text-emerald-400">Soporte</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Customization Modal -->
    <div id="customizationModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4"
         x-data="{ show: false }">
        <div class="bg-slate-900 rounded-2xl border border-slate-700 shadow-2xl max-w-md w-full transform transition-all"
             @click.away="closeCustomizationModal()">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white" id="modalProductName">Personalizar Producto</h3>
                    <button type="button"
                            onclick="closeCustomizationModal()"
                            class="text-slate-400 hover:text-white transition">
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
                                class="flex-1 rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-700 hover:text-white">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/50">
                            Agregar al Carrito
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function dashboardApp() {
            return {
                init() {
                    console.log('Dashboard initialized');
                }
            }
        }

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
                        <label class="block text-sm font-semibold text-slate-300 mb-2">${label}</label>
                        <select name="customizations[customization_${productId}_${index}]"
                                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm text-white focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition"
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

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
