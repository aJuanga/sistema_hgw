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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">

    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-amber-900/95 to-orange-900/95 backdrop-blur-md border-b border-amber-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('client.dashboard') }}" class="flex items-center space-x-3 hover:opacity-80 transition">
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
                            <p class="text-xs text-amber-100">Mi Perfil</p>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('client.dashboard') }}"
                       class="inline-flex items-center space-x-2 rounded-lg border border-white/30 bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="hidden sm:inline">Volver al Catálogo</span>
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

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Encabezado con Foto Grande -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 h-32"></div>
            <div class="px-8 pb-8">
                <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-16 space-y-4 sm:space-y-0 sm:space-x-6">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}"
                             alt="{{ $user->name }}"
                             class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-xl">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 border-4 border-white shadow-xl flex items-center justify-center">
                            <span class="text-white font-black text-5xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif

                    <div class="text-center sm:text-left flex-1 mt-4 sm:mt-0">
                        <h1 class="text-3xl font-black text-slate-900">{{ $user->name }} {{ $user->last_name }}</h1>
                        <p class="text-slate-600 font-medium mt-1">Cliente de Healthy Glow Wellness</p>
                        <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                Cuenta Activa
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold">
                                Miembro desde {{ $user->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de Información -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Columna Izquierda: Información Personal -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Información de Contacto -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Información de Contacto
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-600">Correo Electrónico</p>
                                <p class="text-base font-semibold text-slate-900">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-600">Teléfono</p>
                                <p class="text-base font-semibold text-slate-900">{{ $user->phone ?? 'No registrado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Salud -->
                @if($user->allergies)
                <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-xl border border-red-200 shadow-sm p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Alergias o Condiciones de Salud
                    </h2>
                    <div class="bg-white rounded-lg p-4 border border-red-200">
                        <p class="text-slate-700 whitespace-pre-line">{{ $user->allergies }}</p>
                    </div>
                    <p class="text-xs text-red-700 mt-3 font-medium">
                        Esta información nos ayuda a recomendarte productos seguros para ti.
                    </p>
                </div>
                @else
                <div class="bg-blue-50 rounded-xl border border-blue-200 shadow-sm p-6">
                    <div class="flex items-center space-x-3">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-slate-900">No has registrado alergias</h3>
                            <p class="text-sm text-slate-600">Puedes actualizar tu perfil para ayudarnos a recomendarte mejor.</p>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Columna Derecha: Estadísticas -->
            <div class="space-y-6">

                <!-- Estadísticas de Pedidos -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Mis Estadísticas</h2>
                    <div class="space-y-4">
                        <div class="text-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg border border-green-200">
                            <p class="text-3xl font-black text-green-700">{{ $stats['totalOrders'] }}</p>
                            <p class="text-sm font-medium text-slate-600 mt-1">Pedidos Totales</p>
                        </div>

                        <div class="text-center p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg border border-amber-200">
                            <p class="text-3xl font-black text-amber-700">Bs. {{ number_format($stats['totalSpent'], 2) }}</p>
                            <p class="text-sm font-medium text-slate-600 mt-1">Total Gastado</p>
                        </div>

                        <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                            <p class="text-3xl font-black text-purple-700">{{ $stats['loyaltyPoints'] }}</p>
                            <p class="text-sm font-medium text-slate-600 mt-1">Puntos de Lealtad</p>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Acciones Rápidas</h2>
                    <div class="space-y-2">
                        <a href="{{ route('client.dashboard') }}"
                           class="flex items-center justify-between p-3 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition group">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-slate-600 group-hover:text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-700 group-hover:text-amber-800">Ver Catálogo</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="{{ route('client.orders') }}"
                           class="flex items-center justify-between p-3 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition group">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-slate-600 group-hover:text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-700 group-hover:text-amber-800">Mis Pedidos</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="{{ route('client.cart') }}"
                           class="flex items-center justify-between p-3 rounded-lg border border-slate-200 hover:border-amber-300 hover:bg-amber-50 transition group">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-slate-600 group-hover:text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-700 group-hover:text-amber-800">Mi Carrito</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </main>

</body>
</html>
