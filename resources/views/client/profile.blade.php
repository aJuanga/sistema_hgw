@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mi Perfil - {{ config('app.name', 'Healthy Glow Wellness') }}</title>
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
                        <p class="text-sm font-semibold text-white">Mi Perfil</p>
                        <p class="text-xs text-slate-400 -mt-0.5">Gestiona tu cuenta</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('client.dashboard') }}"
                       class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-slate-700/50 hover:border-emerald-500/50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="hidden sm:inline">Volver al inicio</span>
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
        <!-- Success/Error Messages -->
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

        <div class="grid gap-6 lg:grid-cols-[300px,1fr]">
            <!-- Profile Sidebar -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in text-center">
                    <div class="relative inline-block mb-4">
                        <div class="h-24 w-24 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-emerald-500/50 mx-auto">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <button class="absolute bottom-0 right-0 p-2 rounded-full bg-slate-800 border-2 border-slate-700 text-slate-300 hover:bg-slate-700 hover:text-emerald-400 transition">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-1">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-400 mb-4">{{ $user->email }}</p>
                    <div class="inline-flex items-center space-x-1 rounded-full bg-emerald-500/20 border border-emerald-500/50 px-3 py-1 text-xs font-semibold text-emerald-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <span>Cliente</span>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in">
                    <h3 class="text-sm font-bold text-white mb-4 flex items-center">
                        <svg class="h-5 w-5 text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Estadísticas
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Pedidos totales</span>
                            <span class="text-lg font-bold text-white">{{ $stats['totalOrders'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Gastado</span>
                            <span class="text-lg font-bold text-emerald-400">Bs. {{ number_format($stats['totalSpent'], 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Puntos</span>
                            <span class="text-lg font-bold text-amber-400">{{ $stats['loyaltyPoints'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="space-y-6">
                <!-- Loyalty Points -->
                <div class="rounded-2xl border border-slate-800/50 bg-gradient-to-br from-amber-500/10 to-orange-500/10 backdrop-blur-xl p-6 shadow-xl animate-fade-in border-amber-500/20">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 rounded-xl bg-amber-500/20 border border-amber-500/30">
                                <svg class="h-6 w-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Puntos de Lealtad</h3>
                                <p class="text-sm text-amber-300/70">Tus recompensas wellness</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold text-amber-400">{{ $stats['loyaltyPoints'] }}</p>
                            <p class="text-xs text-amber-300/70">puntos disponibles</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-xl bg-slate-900/50 border border-slate-700/50 p-4">
                            <p class="text-xs text-slate-400 mb-1">Ganados este mes</p>
                            <p class="text-2xl font-bold text-emerald-400">+{{ $stats['pointsThisMonth'] ?? 0 }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-900/50 border border-slate-700/50 p-4">
                            <p class="text-xs text-slate-400 mb-1">Canjeados</p>
                            <p class="text-2xl font-bold text-slate-300">{{ $stats['pointsRedeemed'] ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="mt-4 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20">
                        <p class="text-xs text-amber-300 flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Gana 1 punto por cada Bs. 10 gastados. Canjea tus puntos por descuentos y productos especiales.
                        </p>
                    </div>
                </div>

                <!-- Order History -->
                <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-2">
                            <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <h3 class="text-xl font-bold text-white">Historial de Pedidos</h3>
                        </div>
                        <a href="{{ route('client.orders') }}" class="text-sm font-medium text-emerald-400 hover:text-emerald-300 transition">
                            Ver todos →
                        </a>
                    </div>

                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="group rounded-xl border border-slate-700/50 bg-slate-800/30 p-4 transition-all hover:border-emerald-500/50 hover:bg-slate-800/50">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 rounded-lg {{ $order->status === 'completed' || $order->status === 'delivered' ? 'bg-green-500/20' : ($order->status === 'cancelled' ? 'bg-rose-500/20' : 'bg-orange-500/20') }}">
                                                <svg class="h-5 w-5 {{ $order->status === 'completed' || $order->status === 'delivered' ? 'text-green-400' : ($order->status === 'cancelled' ? 'text-rose-400' : 'text-orange-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($order->status === 'completed' || $order->status === 'delivered')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    @elseif($order->status === 'cancelled')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    @endif
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-white">#{{ $order->order_number }}</p>
                                                <p class="text-xs text-slate-400">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                            {{ $order->status === 'completed' || $order->status === 'delivered' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : '' }}
                                            {{ $order->status === 'pending' || $order->status === 'processing' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/30' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-400">{{ $order->orderItems->count() }} {{ $order->orderItems->count() == 1 ? 'producto' : 'productos' }}</span>
                                        <span class="text-lg font-bold text-emerald-400">Bs. {{ number_format($order->total, 2) }}</span>
                                    </div>

                                    @if($order->orderItems->count() > 0)
                                        <div class="mt-3 pt-3 border-t border-slate-700/50">
                                            <p class="text-xs text-slate-500 mb-2">Productos:</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($order->orderItems->take(3) as $item)
                                                    <span class="inline-flex items-center rounded-lg bg-slate-700/30 px-2 py-1 text-xs text-slate-300">
                                                        {{ $item->product->name ?? 'Producto' }} ({{ $item->quantity }})
                                                    </span>
                                                @endforeach
                                                @if($order->orderItems->count() > 3)
                                                    <span class="inline-flex items-center rounded-lg bg-slate-700/30 px-2 py-1 text-xs text-slate-400">
                                                        +{{ $order->orderItems->count() - 3 }} más
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-white mb-2">No tienes pedidos aún</h3>
                            <p class="text-sm text-slate-400 mb-4">Comienza tu experiencia wellness</p>
                            <a href="{{ route('client.dashboard') }}"
                               class="inline-flex items-center space-x-2 rounded-xl bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600">
                                <span>Explorar Productos</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Profile Information -->
                <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in">
                    <div class="flex items-center space-x-2 mb-6">
                        <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <h3 class="text-xl font-bold text-white">Información Personal</h3>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-300 mb-2">Nombre Completo</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full rounded-xl border-2 border-slate-700/50 bg-slate-800/30 px-4 py-3 text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                            @error('name')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full rounded-xl border-2 border-slate-700/50 bg-slate-800/30 px-4 py-3 text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                            @error('email')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center space-x-2 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Guardar Cambios</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in">
                    <div class="flex items-center space-x-2 mb-6">
                        <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <h3 class="text-xl font-bold text-white">Cambiar Contraseña</h3>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-slate-300 mb-2">Contraseña Actual</label>
                            <input type="password" name="current_password" id="current_password" required
                                   class="w-full rounded-xl border-2 border-slate-700/50 bg-slate-800/30 px-4 py-3 text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                            @error('current_password')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">Nueva Contraseña</label>
                            <input type="password" name="password" id="password" required
                                   class="w-full rounded-xl border-2 border-slate-700/50 bg-slate-800/30 px-4 py-3 text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                            @error('password')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-300 mb-2">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="w-full rounded-xl border-2 border-slate-700/50 bg-slate-800/30 px-4 py-3 text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center space-x-2 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Actualizar Contraseña</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
