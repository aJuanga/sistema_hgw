@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Healthy Glow Wellness') }} - Inicio</title>

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

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
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

        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }

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
    <nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-xl bg-slate-950/90 border-b border-slate-800/50">
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
                    <a href="#productos"
                       class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-slate-700/50 hover:border-emerald-500/50">
                        <span>Menú</span>
                    </a>

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
                        <span class="hidden sm:inline">Mis Pedidos</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-rose-500/20 hover:border-rose-500/50 hover:text-rose-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative overflow-hidden pt-16 animated-gradient">
        <div class="absolute inset-0 opacity-30" style="background-image: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1800&q=80'); background-size: cover; background-position: center;"></div>

        <!-- Decorative Elements -->
        <div class="absolute top-20 right-10 h-96 w-96 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="absolute bottom-10 left-10 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <!-- Welcome Message -->
            <div class="text-center mb-12 animate-slide-up">
                <p class="text-sm uppercase tracking-[0.3em] text-emerald-400 font-semibold mb-3">Bienvenido de vuelta</p>
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-6">
                    Hola, <span class="bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent">{{ $user->name }}</span>
                </h1>
                <p class="text-xl text-slate-300 max-w-3xl mx-auto mb-8">
                    Tu cafetería wellness en el corazón de la ciudad.<br>
                    Bebidas plant-based, cafés artesanales y snacks funcionales para tu bienestar.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                    <a href="#productos"
                       class="group inline-flex items-center space-x-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-8 py-4 text-lg font-bold text-white shadow-2xl shadow-emerald-500/50 transition hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/70 hover:scale-105">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Hacer un Pedido</span>
                        <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>

                    <button @click="showRatingModal = true"
                            class="group inline-flex items-center space-x-3 rounded-2xl border-2 border-amber-500/50 bg-amber-500/10 px-8 py-4 text-lg font-bold text-amber-300 backdrop-blur transition hover:bg-amber-500/20 hover:border-amber-400 hover:scale-105">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span>Calificar Cafetería</span>
                    </button>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="animate-fade-in delay-100 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 backdrop-blur-xl p-8 text-center transition hover:scale-105 hover:border-emerald-400/50">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 mb-4 shadow-lg shadow-emerald-500/30">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">100% Natural</h3>
                    <p class="text-sm text-slate-300">Ingredientes orgánicos y de origen local para tu salud</p>
                </div>

                <div class="animate-fade-in delay-200 rounded-2xl border border-blue-500/30 bg-blue-500/10 backdrop-blur-xl p-8 text-center transition hover:scale-105 hover:border-blue-400/50">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 mb-4 shadow-lg shadow-blue-500/30">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Preparación Rápida</h3>
                    <p class="text-sm text-slate-300">Tu pedido listo en menos de 15 minutos</p>
                </div>

                <div class="animate-fade-in delay-300 rounded-2xl border border-amber-500/30 bg-amber-500/10 backdrop-blur-xl p-8 text-center transition hover:scale-105 hover:border-amber-400/50">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 mb-4 shadow-lg shadow-amber-500/30">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Gana Puntos</h3>
                    <p class="text-sm text-slate-300">Acumula {{ $stats['loyaltyPoints'] }} puntos y obtén recompensas</p>
                </div>
            </div>

            <!-- User Stats (Compact) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="animate-scale-in delay-100 rounded-xl border border-slate-700/50 bg-slate-900/60 backdrop-blur-xl p-4 text-center">
                    <p class="text-2xl font-bold text-emerald-400">{{ $stats['totalOrders'] }}</p>
                    <p class="text-xs uppercase tracking-wider text-slate-400">Pedidos</p>
                </div>
                <div class="animate-scale-in delay-200 rounded-xl border border-slate-700/50 bg-slate-900/60 backdrop-blur-xl p-4 text-center">
                    <p class="text-2xl font-bold text-blue-400">Bs. {{ number_format($stats['totalSpent'], 0) }}</p>
                    <p class="text-xs uppercase tracking-wider text-slate-400">Gastado</p>
                </div>
                <div class="animate-scale-in delay-300 rounded-xl border border-slate-700/50 bg-slate-900/60 backdrop-blur-xl p-4 text-center">
                    <p class="text-2xl font-bold text-amber-400">{{ $stats['loyaltyPoints'] }}</p>
                    <p class="text-xs uppercase tracking-wider text-slate-400">Puntos</p>
                </div>
                <div class="animate-scale-in delay-400 rounded-xl border border-slate-700/50 bg-slate-900/60 backdrop-blur-xl p-4 text-center">
                    <p class="text-2xl font-bold text-orange-400">{{ $stats['pendingOrders'] }}</p>
                    <p class="text-xs uppercase tracking-wider text-slate-400">Pendientes</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Recent Orders (if any) -->
    @if($recentOrders->count() > 0)
    <section class="relative bg-slate-950 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">Tus Pedidos Recientes</h2>
                        <p class="text-sm text-slate-400">Seguimiento en tiempo real de tus órdenes</p>
                    </div>
                    <a href="{{ route('client.orders') }}"
                       class="inline-flex items-center space-x-2 text-sm font-semibold text-emerald-400 hover:text-emerald-300 transition">
                        <span>Ver todos</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    @foreach($recentOrders as $order)
                    <div class="rounded-xl border border-slate-700/50 bg-slate-800/50 p-6 transition hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-500/10">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-lg font-bold text-emerald-400">#{{ $order->order_number }}</span>
                            @if($order->status === 'pending')
                                <span class="inline-flex items-center rounded-full bg-orange-500/20 px-3 py-1 text-xs font-semibold text-orange-400">
                                    <span class="mr-1.5 h-2 w-2 rounded-full bg-orange-400 animate-pulse"></span>
                                    Pendiente
                                </span>
                            @elseif($order->status === 'processing')
                                <span class="inline-flex items-center rounded-full bg-blue-500/20 px-3 py-1 text-xs font-semibold text-blue-400">
                                    <span class="mr-1.5 h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                                    En Preparación
                                </span>
                            @elseif($order->status === 'ready')
                                <span class="inline-flex items-center rounded-full bg-green-500/20 px-3 py-1 text-xs font-semibold text-green-400">
                                    <span class="mr-1.5 h-2 w-2 rounded-full bg-green-400"></span>
                                    Listo
                                </span>
                            @elseif($order->status === 'completed' || $order->status === 'delivered')
                                <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-semibold text-emerald-400">
                                    ✓ Entregado
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-300 mb-3">{{ $order->orderItems->count() }} productos</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-white">Bs. {{ number_format($order->total, 2) }}</span>
                            <span class="text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Products Section -->
    <section id="productos" class="relative bg-slate-950 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-white mb-4">Nuestro Menú Wellness</h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                    Descubre bebidas y snacks cuidadosamente seleccionados para nutrir tu cuerpo y alma
                </p>
            </div>

            <!-- Search Bar -->
            <div class="mb-10">
                <form method="GET" action="{{ route('client.dashboard') }}" class="max-w-2xl mx-auto">
                    <div class="flex gap-3">
                        <div class="relative flex-1">
                            <input type="text"
                                   name="search"
                                   value="{{ $search ?? '' }}"
                                   placeholder="Buscar matcha, cacao, cold brew..."
                                   class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-4 pl-12 text-sm text-slate-100 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                            <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700">
                            Buscar
                        </button>
                        @if($search)
                            <a href="{{ route('client.dashboard') }}"
                               class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-800/50 px-6 py-4 text-sm font-medium text-slate-300 transition hover:bg-slate-700/50">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach($products as $product)
                        <article class="group relative overflow-hidden rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl shadow-xl transition-all duration-300 hover:-translate-y-2 hover:border-emerald-500/50 hover:shadow-2xl hover:shadow-emerald-500/20">
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

                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/30 to-transparent"></div>

                                <div class="absolute left-3 top-3">
                                    <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 backdrop-blur-xl px-3 py-1 text-xs font-semibold text-white">
                                        {{ $product->category->name ?? 'Wellness' }}
                                    </span>
                                </div>

                                <div class="absolute right-3 top-3">
                                    <span class="inline-flex items-center space-x-1 rounded-full {{ $product->is_available ? 'bg-green-500/90' : 'bg-rose-500/90' }} px-2 py-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                        <span class="text-xs font-medium text-white">{{ $product->is_available ? 'Disponible' : 'Agotado' }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 space-y-4">
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-1">{{ $product->name }}</h3>
                                    <p class="text-xs uppercase tracking-wider text-emerald-400 font-medium">Ritual diario</p>
                                </div>

                                <p class="text-sm text-slate-400 line-clamp-2">
                                    {{ $product->description ?: 'Producto premium con ingredientes naturales seleccionados.' }}
                                </p>

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

                                <div class="flex items-center gap-2 pt-2">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="flex-1 inline-flex items-center justify-center space-x-1 rounded-xl border border-slate-700 bg-slate-800/50 px-4 py-2.5 text-sm font-medium text-slate-200 transition hover:bg-slate-700/50 hover:border-emerald-500/50 hover:text-emerald-300">
                                        <span>Ver</span>
                                    </a>

                                    @if($product->is_available)
                                        @if($product->customization_options && count($product->customization_options) > 0)
                                            <button type="button"
                                                    onclick="showCustomizationModal({{ $product->id }})"
                                                    class="flex-1 inline-flex items-center justify-center space-x-1 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700 hover:scale-105">
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
                                                        class="w-full inline-flex items-center justify-center space-x-1 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700 hover:scale-105">
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

                <div class="mt-10">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/50 backdrop-blur-xl p-12 text-center">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-800/50 mb-4">
                        <svg class="h-8 w-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No hay productos disponibles</h3>
                    <p class="text-sm text-slate-400">Nuestro laboratorio sensorial está preparando nuevas recetas.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-800/50 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold">
                            HGW
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Healthy Glow Wellness</p>
                            <p class="text-xs text-slate-400">Café botánico y nutrición consciente</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400">Tu cafetería wellness comprometida con tu salud y el planeta.</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-white mb-3">Horarios</h3>
                    <p class="text-sm text-slate-400 mb-1">Lunes - Sábado</p>
                    <p class="text-sm text-emerald-400 font-semibold mb-3">8:00 AM - 8:00 PM</p>
                    <p class="text-sm text-slate-400">Domingo: Cerrado</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-white mb-3">Contacto</h3>
                    <p class="text-sm text-slate-400 mb-2">📍 Centro de la Ciudad</p>
                    <p class="text-sm text-slate-400 mb-2">📞 +591 123 456 789</p>
                    <a href="mailto:soporte@healthyglow.com" class="text-sm text-emerald-400 hover:text-emerald-300 transition">
                        ✉️ soporte@healthyglow.com
                    </a>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-500">
                <p>&copy; {{ now()->year }} Healthy Glow Wellness. Todos los derechos reservados.</p>
                <div class="flex flex-wrap gap-6">
                    <a href="#" class="transition hover:text-emerald-400">Política de bienestar</a>
                    <a href="#" class="transition hover:text-emerald-400">Términos</a>
                    <a href="#" class="transition hover:text-emerald-400">Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Rating Modal -->
    <div x-show="showRatingModal"
         x-cloak
         @click.self="showRatingModal = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
        <div class="bg-slate-900 rounded-2xl border border-slate-700 shadow-2xl max-w-md w-full transform transition-all"
             @click.away="showRatingModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-white">Califica tu Experiencia</h3>
                    <button type="button"
                            @click="showRatingModal = false"
                            class="text-slate-400 hover:text-white transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="text-center mb-6">
                    <p class="text-slate-300 mb-4">¿Cómo fue tu experiencia en Healthy Glow Wellness?</p>

                    <!-- Star Rating -->
                    <div class="flex items-center justify-center space-x-2 mb-6">
                        <template x-for="star in 5" :key="star">
                            <button @click="rating = star"
                                    class="transition-transform hover:scale-110">
                                <svg :class="star <= rating ? 'text-amber-400' : 'text-slate-600'"
                                     class="h-10 w-10 fill-current"
                                     viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </button>
                        </template>
                    </div>

                    <textarea x-model="ratingComment"
                              placeholder="Cuéntanos más sobre tu experiencia (opcional)..."
                              class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition"
                              rows="4"></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button"
                            @click="showRatingModal = false"
                            class="flex-1 rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-700">
                        Cancelar
                    </button>
                    <button type="button"
                            @click="submitRating()"
                            class="flex-1 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700">
                        Enviar Calificación
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Customization Modal -->
    <div id="customizationModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4">
        <div class="bg-slate-900 rounded-2xl border border-slate-700 shadow-2xl max-w-md w-full">
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

                    <div id="customizationOptions" class="space-y-4 mb-6"></div>

                    <div class="flex gap-3">
                        <button type="button"
                                onclick="closeCustomizationModal()"
                                class="flex-1 rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-700">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700">
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
                showRatingModal: false,
                rating: 0,
                ratingComment: '',

                submitRating() {
                    if (this.rating === 0) {
                        alert('Por favor selecciona una calificación');
                        return;
                    }

                    // Aquí harías la petición AJAX para guardar la calificación
                    console.log('Rating:', this.rating, 'Comment:', this.ratingComment);

                    alert('¡Gracias por tu calificación! Tu opinión nos ayuda a mejorar.');
                    this.showRatingModal = false;
                    this.rating = 0;
                    this.ratingComment = '';
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

        document.getElementById('customizationModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCustomizationModal();
            }
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
