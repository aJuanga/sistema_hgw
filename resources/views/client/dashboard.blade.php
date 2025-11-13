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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

        @keyframes steam {
            0%, 100% {
                transform: translateY(0) translateX(0) scaleX(1);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-30px) translateX(10px) scaleX(1.2);
                opacity: 0;
            }
        }

        .steam-effect {
            position: relative;
        }

        .steam-effect::before,
        .steam-effect::after {
            content: '';
            position: absolute;
            bottom: 100%;
            left: 50%;
            width: 3px;
            height: 30px;
            background: linear-gradient(to top, rgba(139, 92, 65, 0.3), transparent);
            filter: blur(3px);
            animation: steam 4s ease-in-out infinite;
        }

        .steam-effect::after {
            animation-delay: 2s;
            left: 60%;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

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

        .animate-float {
            animation: float 3s ease-in-out infinite;
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

        /* Coffee bean pattern background */
        .coffee-pattern {
            background-color: #2d1f1a;
            background-image:
                radial-gradient(ellipse at center, rgba(139, 92, 65, 0.1) 0%, transparent 50%),
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(139, 92, 65, 0.05) 10px, rgba(139, 92, 65, 0.05) 20px);
        }

        /* Coffee stain effect */
        .coffee-stain {
            position: relative;
            overflow: hidden;
        }

        .coffee-stain::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(139, 92, 65, 0.15), transparent 70%);
            border-radius: 43% 57% 48% 52% / 61% 44% 56% 39%;
            transform: rotate(25deg);
        }

        /* Latte art gradient */
        .latte-gradient {
            background: linear-gradient(135deg,
                #8B5C41 0%,
                #A67C52 20%,
                #C8A882 40%,
                #E8D4B8 60%,
                #F5EBD8 80%,
                #FFF8E7 100%);
        }

        /* Coffee texture overlay */
        .coffee-texture {
            background-image:
                linear-gradient(30deg, #2d1f1a 12%, transparent 12.5%, transparent 87%, #2d1f1a 87.5%, #2d1f1a),
                linear-gradient(150deg, #2d1f1a 12%, transparent 12.5%, transparent 87%, #2d1f1a 87.5%, #2d1f1a),
                linear-gradient(30deg, #2d1f1a 12%, transparent 12.5%, transparent 87%, #2d1f1a 87.5%, #2d1f1a),
                linear-gradient(150deg, #2d1f1a 12%, transparent 12.5%, transparent 87%, #2d1f1a 87.5%, #2d1f1a);
            background-size: 80px 140px;
            background-position: 0 0, 0 0, 40px 70px, 40px 70px;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-xl bg-gradient-to-r from-amber-900/95 via-orange-900/95 to-amber-900/95 border-b-2 border-amber-700/30 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center space-x-4">
                    <div class="relative steam-effect h-14 w-14 rounded-2xl bg-gradient-to-br from-amber-400 via-orange-500 to-amber-600 flex items-center justify-center text-white font-bold shadow-2xl shadow-amber-600/50 animate-float">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-display text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-200 to-yellow-100">Healthy Glow</p>
                        <p class="text-xs tracking-[0.3em] text-amber-300 font-semibold uppercase -mt-1">Cafetería Saludable</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('client.cart') }}"
                       class="relative inline-flex items-center space-x-2 rounded-2xl border-2 border-amber-600/50 bg-amber-800/50 px-5 py-3 text-sm font-bold text-amber-100 backdrop-blur transition hover:bg-amber-700/60 hover:border-yellow-400/70 hover:shadow-lg hover:shadow-amber-500/30 hover:scale-105">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="hidden sm:inline">Carrito</span>
                        @php
                            $cartCount = count(session()->get('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-br from-red-500 to-orange-600 text-xs font-black text-white shadow-lg shadow-red-500/60 ring-4 ring-amber-900/50">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('client.orders') }}"
                       class="inline-flex items-center space-x-2 rounded-2xl border-2 border-amber-600/50 bg-amber-800/50 px-5 py-3 text-sm font-bold text-amber-100 backdrop-blur transition hover:bg-amber-700/60 hover:border-yellow-400/70 hover:shadow-lg hover:shadow-amber-500/30 hover:scale-105">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="hidden sm:inline">Pedidos</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center space-x-2 rounded-2xl border-2 border-red-600/50 bg-red-900/50 px-5 py-3 text-sm font-bold text-red-200 backdrop-blur transition hover:bg-red-800/60 hover:border-red-400/70 hover:shadow-lg hover:shadow-red-500/30 hover:scale-105">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Coffee Theme -->
    <header class="relative overflow-hidden pt-20 pb-12 coffee-pattern">
        <!-- Coffee Background Image -->
        <div class="absolute inset-0 opacity-10" style="background-image: url('https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1800&q=80'); background-size: cover; background-position: center; filter: sepia(30%);"></div>

        <!-- Decorative Coffee Elements -->
        <div class="absolute top-20 right-10 h-96 w-96 rounded-full bg-gradient-to-br from-amber-600/20 to-orange-600/20 blur-3xl"></div>
        <div class="absolute bottom-10 left-10 h-96 w-96 rounded-full bg-gradient-to-br from-yellow-600/20 to-amber-600/20 blur-3xl"></div>
        <div class="absolute top-40 left-1/3 h-64 w-64 rounded-full bg-gradient-to-br from-orange-600/15 to-red-600/15 blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-12 animate-slide-up">
                <div class="inline-flex items-center space-x-2 mb-4 px-6 py-2 rounded-full bg-gradient-to-r from-amber-800/80 to-orange-800/80 backdrop-blur-xl border-2 border-amber-600/30">
                    <svg class="w-5 h-5 text-yellow-400 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm uppercase tracking-[0.3em] text-amber-200 font-bold">Tu Pausa Saludable</span>
                </div>

                <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-800 via-orange-700 to-amber-900 mb-6 drop-shadow-lg">
                    ¡Hola, {{ $user->name }}!
                </h1>
                <p class="text-xl text-amber-900 max-w-3xl mx-auto font-medium leading-relaxed">
                    ☕ Descubre nuestros <span class="font-bold text-orange-800">cafés artesanales</span>, bebidas plant-based y snacks funcionales.<br>
                    Cada taza cuenta una historia de sabor y bienestar.
                </p>
            </div>

            <!-- Stats Grid with Coffee Theme -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
                <div class="stat-card delay-100 rounded-3xl border-3 border-amber-700/30 bg-gradient-to-br from-amber-100 via-orange-50 to-yellow-100 backdrop-blur-xl p-8 text-center transform transition-all duration-300 hover:scale-110 hover:shadow-2xl hover:shadow-amber-600/40 hover:-translate-y-2 coffee-stain">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600 mb-4 shadow-xl shadow-amber-600/50">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-black text-amber-900 mb-2">{{ $stats['totalOrders'] }}</p>
                    <p class="text-xs uppercase tracking-widest text-amber-700 font-bold">Pedidos</p>
                </div>

                <div class="stat-card delay-200 rounded-3xl border-3 border-amber-700/30 bg-gradient-to-br from-orange-100 via-amber-50 to-yellow-100 backdrop-blur-xl p-8 text-center transform transition-all duration-300 hover:scale-110 hover:shadow-2xl hover:shadow-orange-600/40 hover:-translate-y-2 coffee-stain">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-orange-500 via-red-500 to-orange-600 mb-4 shadow-xl shadow-orange-600/50">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-black text-orange-900 mb-2">Bs. {{ number_format($stats['totalSpent'], 2) }}</p>
                    <p class="text-xs uppercase tracking-widest text-orange-700 font-bold">Gastado</p>
                </div>

                <div class="stat-card delay-300 rounded-3xl border-3 border-amber-700/30 bg-gradient-to-br from-yellow-100 via-amber-50 to-orange-100 backdrop-blur-xl p-8 text-center transform transition-all duration-300 hover:scale-110 hover:shadow-2xl hover:shadow-yellow-600/40 hover:-translate-y-2 coffee-stain">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-yellow-500 via-amber-500 to-yellow-600 mb-4 shadow-xl shadow-yellow-600/50">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-black text-yellow-900 mb-2">{{ $stats['loyaltyPoints'] }}</p>
                    <p class="text-xs uppercase tracking-widest text-yellow-700 font-bold">Puntos</p>
                </div>

                <div class="stat-card delay-400 rounded-3xl border-3 border-amber-700/30 bg-gradient-to-br from-amber-100 via-yellow-50 to-orange-100 backdrop-blur-xl p-8 text-center transform transition-all duration-300 hover:scale-110 hover:shadow-2xl hover:shadow-amber-600/40 hover:-translate-y-2 coffee-stain">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-amber-600 via-orange-600 to-red-600 mb-4 shadow-xl shadow-orange-600/50">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-black text-orange-900 mb-2">{{ $stats['pendingOrders'] }}</p>
                    <p class="text-xs uppercase tracking-widest text-orange-700 font-bold">Pendientes</p>
                </div>

                <div class="stat-card delay-100 rounded-3xl border-3 border-amber-700/30 bg-gradient-to-br from-green-100 via-emerald-50 to-teal-100 backdrop-blur-xl p-8 text-center transform transition-all duration-300 hover:scale-110 hover:shadow-2xl hover:shadow-green-600/40 hover:-translate-y-2 coffee-stain">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-green-500 via-emerald-500 to-teal-600 mb-4 shadow-xl shadow-green-600/50">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-black text-green-900 mb-2">{{ $stats['completedOrders'] }}</p>
                    <p class="text-xs uppercase tracking-widest text-green-700 font-bold">Completados</p>
                </div>
            </div>

            <!-- Recent Orders Section -->
            @if($recentOrders->count() > 0)
            <div class="animate-fade-in delay-200 rounded-3xl border-3 border-amber-700/30 bg-gradient-to-br from-white/90 to-amber-50/90 backdrop-blur-2xl p-8 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-display text-3xl font-black text-amber-900">☕ Pedidos Recientes</h3>
                    <a href="{{ route('client.orders') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-orange-700 hover:text-orange-900 transition px-6 py-3 rounded-2xl bg-orange-100 hover:bg-orange-200 border-2 border-orange-300">
                        <span>Ver todos</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach($recentOrders as $order)
                    <div class="rounded-2xl border-2 border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50 p-6 transition hover:border-orange-400 hover:shadow-xl hover:shadow-orange-300/30 hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-base font-black text-orange-700">#{{ $order->order_number }}</span>
                            <span class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-black
                                {{ $order->status === 'completed' || $order->status === 'delivered' ? 'bg-green-200 text-green-800 border-2 border-green-400' : '' }}
                                {{ $order->status === 'pending' || $order->status === 'processing' ? 'bg-orange-200 text-orange-800 border-2 border-orange-400' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-rose-200 text-rose-800 border-2 border-rose-400' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-amber-800 font-semibold mb-3">{{ $order->orderItems->count() }} productos</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-900">Bs. {{ number_format($order->total, 2) }}</span>
                            <span class="text-xs text-amber-600 font-semibold">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- Search and Filter Section -->
            <section class="mb-12 animate-scale-in">
                <div class="rounded-3xl border-3 border-amber-700/30 bg-gradient-to-br from-white/95 to-amber-50/95 backdrop-blur-2xl p-8 shadow-2xl coffee-stain">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <h2 class="font-display text-4xl font-black text-amber-900 mb-3">☕ Menú Wellness</h2>
                            <p class="text-base text-amber-700 font-medium">Tu próxima pausa consciente te espera</p>
                        </div>

                        <form method="GET" action="{{ route('client.dashboard') }}" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                            <div class="relative flex-1 lg:min-w-[350px]">
                                <input type="text"
                                       name="search"
                                       value="{{ $search ?? '' }}"
                                       placeholder="Buscar café, matcha, smoothies..."
                                       class="w-full rounded-2xl border-3 border-amber-300 bg-white px-6 py-4 pl-14 text-sm text-amber-900 font-semibold placeholder:text-amber-400 focus:border-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-300/30 transition shadow-lg">
                                <svg class="absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <button type="submit"
                                    class="inline-flex items-center justify-center space-x-2 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-600 to-orange-500 px-8 py-4 text-sm font-black text-white shadow-xl shadow-orange-500/40 transition hover:from-orange-600 hover:via-amber-700 hover:to-orange-600 hover:shadow-2xl hover:shadow-orange-500/60 hover:scale-105">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span>Buscar</span>
                            </button>
                            @if($search)
                                <a href="{{ route('client.dashboard') }}"
                                   class="inline-flex items-center justify-center rounded-2xl border-2 border-amber-300 bg-amber-100 px-6 py-4 text-sm font-bold text-amber-800 transition hover:bg-amber-200 hover:border-amber-400 hover:scale-105">
                                    Limpiar
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Category Filter -->
                    @if($categories->count() > 0)
                    <div class="mt-8 flex flex-wrap gap-3">
                        <span class="text-sm text-amber-800 font-black mr-2">Categorías:</span>
                        @foreach($categories as $category)
                        <button class="inline-flex items-center space-x-2 rounded-full border-2 border-amber-400 bg-gradient-to-r from-amber-100 to-orange-100 px-6 py-2.5 text-xs font-black text-amber-800 transition hover:from-orange-200 hover:to-amber-200 hover:border-orange-500 hover:scale-110 shadow-md hover:shadow-lg">
                            <span>{{ $category->name }}</span>
                            <span class="text-orange-600">({{ $category->products_count }})</span>
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </section>

            <!-- Products Grid -->
            @if($products->count())
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-12">
                    @foreach($products as $index => $product)
                        <article class="product-card group relative overflow-hidden rounded-3xl border-3 border-amber-300 bg-gradient-to-br from-white via-amber-50 to-orange-50 shadow-xl transition-all duration-500 hover:-translate-y-3 hover:border-orange-400 hover:shadow-2xl hover:shadow-orange-400/40"
                                 style="animation-delay: {{ ($index % 4) * 0.1 }}s">
                            <!-- Image -->
                            <div class="relative h-56 overflow-hidden bg-gradient-to-br from-amber-200 to-orange-200">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="h-full w-full object-cover transition duration-700 group-hover:scale-125 group-hover:rotate-3">
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-amber-300 to-orange-400">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-amber-900/30 via-transparent to-transparent"></div>

                                <!-- Category Badge -->
                                <div class="absolute left-4 top-4">
                                    <span class="inline-flex items-center rounded-full border-2 border-white/50 bg-white/90 backdrop-blur-xl px-4 py-2 text-xs font-black text-amber-900 shadow-lg">
                                        {{ $product->category->name ?? 'Wellness' }}
                                    </span>
                                </div>

                                <!-- Availability Badge -->
                                <div class="absolute right-4 top-4">
                                    <span class="inline-flex items-center space-x-1.5 rounded-full border-2 {{ $product->is_available ? 'bg-green-500 border-green-300' : 'bg-rose-500 border-rose-300' }} px-3 py-2 shadow-lg">
                                        <span class="h-2 w-2 rounded-full {{ $product->is_available ? 'bg-white animate-pulse' : 'bg-white' }}"></span>
                                        <span class="text-xs font-black text-white">{{ $product->is_available ? 'Disponible' : 'Agotado' }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 space-y-4">
                                <div>
                                    <h3 class="font-display text-xl font-black text-amber-900 mb-1 line-clamp-1">{{ $product->name }}</h3>
                                    <p class="text-xs uppercase tracking-widest text-orange-600 font-bold">☕ Café artesanal</p>
                                </div>

                                <p class="text-sm text-amber-700 line-clamp-2 font-medium leading-relaxed">
                                    {{ $product->description ?: '☕ Producto premium con ingredientes naturales y café de origen.' }}
                                </p>

                                <!-- Price and Time -->
                                <div class="flex items-center justify-between pt-2 border-t-2 border-amber-200">
                                    <span class="text-3xl font-black text-amber-900">Bs. {{ number_format($product->price, 2) }}</span>
                                    @if($product->preparation_time)
                                        <span class="flex items-center space-x-1.5 text-xs text-amber-700 font-bold bg-amber-100 px-3 py-1.5 rounded-full">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $product->preparation_time }} min</span>
                                        </span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-3 pt-4">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="flex-1 inline-flex items-center justify-center space-x-1.5 rounded-2xl border-2 border-amber-400 bg-amber-100 px-4 py-3 text-sm font-black text-amber-900 transition hover:bg-amber-200 hover:border-orange-500 hover:scale-105">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Ver</span>
                                    </a>

                                    @if($product->is_available)
                                        @if($product->customization_options && count($product->customization_options) > 0)
                                            <button type="button"
                                                    onclick="showCustomizationModal({{ $product->id }})"
                                                    class="flex-1 inline-flex items-center justify-center space-x-1.5 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-600 to-orange-500 px-4 py-3 text-sm font-black text-white shadow-xl shadow-orange-500/40 transition hover:from-orange-600 hover:via-amber-700 hover:to-orange-600 hover:shadow-2xl hover:shadow-orange-500/60 hover:scale-110">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                <span>Agregar</span>
                                            </button>
                                        @else
                                            <form action="{{ route('client.cart.add') }}" method="POST" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                        class="w-full inline-flex items-center justify-center space-x-1.5 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-600 to-orange-500 px-4 py-3 text-sm font-black text-white shadow-xl shadow-orange-500/40 transition hover:from-orange-600 hover:via-amber-700 hover:to-orange-600 hover:shadow-2xl hover:shadow-orange-500/60 hover:scale-110">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
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
                <div class="mt-12 animate-fade-in">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <div class="rounded-3xl border-3 border-dashed border-amber-400 bg-gradient-to-br from-white/90 to-amber-50/90 backdrop-blur-2xl p-16 text-center animate-fade-in shadow-2xl">
                    <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gradient-to-br from-amber-200 to-orange-300 mb-6 shadow-xl">
                        <svg class="h-12 w-12 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-3xl font-black text-amber-900 mb-3">☕ Preparando nuevas recetas</h3>
                    <p class="text-base text-amber-700 font-medium">Nuestros baristas están creando nuevas experiencias. Vuelve pronto.</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t-3 border-amber-300 bg-gradient-to-br from-amber-900 via-orange-900 to-amber-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-sm text-amber-200">
                <p class="font-semibold">☕ © {{ now()->year }} Healthy Glow Wellness. Café botánico y nutrición consciente.</p>
                <div class="flex flex-wrap gap-8">
                    <a href="#" class="font-bold transition hover:text-yellow-300 hover:scale-110">Política de bienestar</a>
                    <a href="#" class="font-bold transition hover:text-yellow-300 hover:scale-110">Términos</a>
                    <a href="mailto:soporte@healthyglow.com" class="font-bold transition hover:text-yellow-300 hover:scale-110">Soporte ☎</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Customization Modal -->
    <div id="customizationModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4"
         x-data="{ show: false }">
        <div class="bg-gradient-to-br from-white to-amber-50 rounded-3xl border-3 border-amber-400 shadow-2xl max-w-md w-full transform transition-all"
             @click.away="closeCustomizationModal()">
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-display text-2xl font-black text-amber-900" id="modalProductName">Personalizar Producto</h3>
                    <button type="button"
                            onclick="closeCustomizationModal()"
                            class="text-amber-600 hover:text-amber-900 transition hover:scale-110">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
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

                    <div class="flex gap-4">
                        <button type="button"
                                onclick="closeCustomizationModal()"
                                class="flex-1 rounded-2xl border-2 border-amber-400 bg-amber-100 px-6 py-4 text-sm font-black text-amber-900 transition hover:bg-amber-200 hover:border-orange-500 hover:scale-105">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-600 to-orange-500 px-6 py-4 text-sm font-black text-white shadow-xl shadow-orange-500/40 transition hover:from-orange-600 hover:via-amber-700 hover:to-orange-600 hover:shadow-2xl hover:shadow-orange-500/60 hover:scale-105">
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
                    console.log('☕ Cafetería Dashboard initialized');
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
            document.getElementById('modalProductName').textContent = '☕ Personalizar ' + product.name;

            const optionsContainer = document.getElementById('customizationOptions');
            optionsContainer.innerHTML = '';

            if (product.customization_options && product.customization_options.length > 0) {
                product.customization_options.forEach((option, index) => {
                    const div = document.createElement('div');
                    const label = option.label || option.name || 'Opción';
                    div.innerHTML = `
                        <label class="block text-sm font-black text-amber-900 mb-2">${label}</label>
                        <select name="customizations[customization_${productId}_${index}]"
                                class="w-full rounded-2xl border-2 border-amber-300 bg-white px-4 py-3 text-sm font-semibold text-amber-900 focus:border-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-300/30 transition"
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
