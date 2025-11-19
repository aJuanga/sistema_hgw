@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Carrito - {{ config('app.name', 'Healthy Glow Wellness') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
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

        .animate-slide-down {
            animation: slideInDown 0.4s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 backdrop-blur-xl bg-slate-950/80 border-b border-slate-800/50 animate-slide-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/50">
                        HGW
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Carrito de Compras</p>
                        <p class="text-xs text-slate-400 -mt-0.5">Revisa tus productos</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('client.dashboard') }}"
                       class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-slate-700/50 hover:border-emerald-500/50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="hidden sm:inline">Continuar comprando</span>
                    </a>

                    <a href="{{ route('client.orders') }}"
                       class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-slate-700/50 hover:border-emerald-500/50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="hidden sm:inline">Mis Pedidos</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-rose-500/20 hover:border-rose-500/50 hover:text-rose-300">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-500/10 border border-emerald-500/50 p-4 text-emerald-200 backdrop-blur-xl animate-fade-in flex items-center space-x-3">
                <svg class="h-5 w-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl bg-rose-500/10 border border-rose-500/50 p-4 text-rose-200 backdrop-blur-xl animate-fade-in flex items-center space-x-3">
                <svg class="h-5 w-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if(count($products) > 0)
            <div class="grid gap-6 lg:gap-8 lg:grid-cols-[1fr,420px]">
                <!-- Cart Items -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-white">Productos ({{ count($products) }})</h2>
                    </div>

                    @foreach($products as $index => $item)
                        <div class="group rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-4 sm:p-6 transition-all duration-300 hover:border-emerald-500/30 hover:shadow-lg hover:shadow-emerald-500/10 animate-fade-in"
                             style="animation-delay: {{ $index * 0.1 }}s; opacity: 0;">
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                                <div class="flex-shrink-0">
                                    @if($item['product']->image)
                                        <img src="{{ asset('storage/'.$item['product']->image) }}"
                                             alt="{{ $item['product']->name }}"
                                             class="h-28 w-28 sm:h-32 sm:w-32 rounded-xl object-cover ring-2 ring-slate-700 group-hover:ring-emerald-500/50 transition-all duration-300">
                                    @else
                                        <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center ring-2 ring-slate-700 group-hover:ring-emerald-500/50 transition-all">
                                            <span class="text-2xl font-bold text-slate-600">HGW</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-2">
                                        <div>
                                            <h3 class="text-lg font-bold text-white line-clamp-1">{{ $item['product']->name }}</h3>
                                            <p class="text-xs text-slate-400 mt-1">
                                                <span class="inline-flex items-center rounded-full bg-slate-800/50 px-2 py-0.5">
                                                    {{ $item['product']->category->name ?? 'Sin categoría' }}
                                                </span>
                                            </p>
                                        </div>
                                        <form action="{{ route('client.cart.remove', $item['product']->id) }}" method="POST" class="flex-shrink-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 rounded-lg text-slate-400 hover:bg-rose-500/20 hover:text-rose-400 transition"
                                                    title="Eliminar del carrito">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    @if($item['product']->customization_options && count($item['product']->customization_options) > 0)
                                        <div class="mt-3 space-y-2 p-3 rounded-lg bg-slate-800/30 border border-slate-700/50">
                                            <p class="text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-2">Personalizaciones</p>
                                            @foreach($item['product']->customization_options as $option)
                                                <div>
                                                    <label class="text-xs text-slate-400 mb-1 block">{{ $option['label'] ?? $option['name'] }}</label>
                                                    <select name="customization_{{ $item['product']->id }}_{{ $loop->index }}"
                                                            class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-white text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                                                        @foreach($option['options'] as $opt)
                                                            <option value="{{ $opt['value'] ?? $opt }}">{{ $opt['label'] ?? $opt }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                                        <form action="{{ route('client.cart.update') }}" method="POST" class="flex items-center gap-3">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                            <div class="flex items-center gap-2">
                                                <label class="text-sm text-slate-400">Cantidad:</label>
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                                       class="w-20 rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-white text-sm text-center focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                                            </div>
                                            <button type="submit"
                                                    class="inline-flex items-center space-x-1 rounded-lg bg-emerald-500/20 border border-emerald-500/50 px-3 py-2 text-xs font-semibold text-emerald-400 transition hover:bg-emerald-500/30">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                <span>Actualizar</span>
                                            </button>
                                        </form>

                                        <div class="text-right">
                                            <p class="text-xs text-slate-500 mb-1">Bs. {{ number_format($item['product']->price, 2) }} × {{ $item['quantity'] }}</p>
                                            <p class="text-xl font-bold text-emerald-400">Bs. {{ number_format($item['subtotal'], 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:sticky lg:top-24 h-fit">
                    <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-2xl animate-fade-in">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">Resumen del Pedido</h2>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Subtotal ({{ count($products) }} {{ count($products) == 1 ? 'producto' : 'productos' }}):</span>
                                <span class="text-white font-medium">Bs. {{ number_format($total, 2) }}</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400 flex items-center space-x-1">
                                    <span>Impuesto (13%):</span>
                                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </span>
                                <span class="text-white font-medium">Bs. {{ number_format($total * 0.13, 2) }}</span>
                            </div>

                            <div class="border-t border-slate-700/50 pt-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-lg font-semibold text-white">Total:</span>
                                    <span class="text-3xl font-bold bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent">
                                        Bs. {{ number_format($total * 1.13, 2) }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 text-right">Todos los impuestos incluidos</p>
                            </div>
                        </div>

                        <a href="{{ route('client.checkout') }}"
                           class="group block w-full rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4 text-center font-bold text-white shadow-lg shadow-emerald-500/30 transition-all duration-300 hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/50 hover:scale-105 mb-3">
                            <span class="flex items-center justify-center space-x-2">
                                <span>Proceder al Pago</span>
                                <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </a>

                        <div class="rounded-lg bg-slate-800/30 border border-slate-700/50 p-4">
                            <div class="flex items-start space-x-3">
                                <svg class="h-5 w-5 text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-white mb-1">Compra Segura</p>
                                    <p class="text-xs text-slate-400 leading-relaxed">Tus datos están protegidos y tu pedido será procesado de forma segura.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/70 p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-slate-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">Tu carrito está vacío</h3>
                <p class="text-slate-400 mb-6">Agrega productos desde el catálogo</p>
                <a href="{{ route('client.dashboard') }}" 
                   class="inline-flex items-center rounded-xl bg-emerald-500 px-6 py-3 font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600">
                    Ver Productos
                </a>
            </div>
        @endif
    </main>
</body>
</html>

