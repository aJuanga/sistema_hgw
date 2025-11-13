<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Sistema HGW</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
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
                animation: slideDown 0.3s ease-out;
            }

            .animate-fade-in {
                animation: fadeIn 0.4s ease-out;
            }

            /* Scrollbar personalizado */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #1e293b;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #475569;
                border-radius: 3px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #64748b;
            }

            /* Glassmorphism effect */
            .glass-effect {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50">
        <div class="min-h-screen">
            <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
                <!-- Sidebar Desktop -->
                <aside class="w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white flex-shrink-0 hidden lg:flex lg:flex-col shadow-2xl border-r border-slate-700/50">
                    <!-- Logo & Brand -->
                    <div class="flex items-center justify-between px-6 py-5 bg-gradient-to-r from-slate-800 to-slate-900 border-b border-slate-700/50">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition"></div>
                                <div class="relative w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-105 transition">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-xl font-black text-white">Sistema HGW</p>
                                <p class="text-xs text-slate-400 font-medium">Healthy Glow Wellness</p>
                            </div>
                        </a>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 overflow-y-auto py-6 px-4 custom-scrollbar">
                        @php
                            $user = Auth::user();
                            $isJefa = $user?->hasRole('jefa');
                            $isAdmin = $user?->hasRole('administrador');
                            $isEmpleado = $user?->hasRole('empleado');
                            $isCliente = $user?->hasRole('cliente');
                            $canManageCatalog = $isJefa || $isAdmin || $isEmpleado;
                            $canManageOperations = $isJefa || $isAdmin || $isEmpleado;
                        @endphp

                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                            <div class="w-10 h-10 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <span class="ml-3 font-semibold">Dashboard</span>
                        </a>

                        @if($isCliente)
                            <!-- Catálogo para Cliente -->
                            <div class="mt-6 mb-3 px-4">
                                <p class="text-xs font-black text-slate-500 uppercase tracking-wider">Tienda</p>
                            </div>

                            <a href="{{ route('client.dashboard') }}"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('client.dashboard') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('client.dashboard') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Catálogo de Productos</span>
                            </a>

                            <a href="{{ route('client.cart') }}"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('client.cart') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('client.cart') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Mi Carrito</span>
                            </a>

                            <a href="{{ route('client.orders') }}"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('client.orders') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('client.orders') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Mis Pedidos</span>
                            </a>
                        @endif

                        @if($canManageCatalog)
                            <div class="mt-6 mb-3 px-4">
                                <p class="text-xs font-black text-slate-500 uppercase tracking-wider">Gestión de Productos</p>
                            </div>

                            <a href="{{ route('products.index') }}"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('products.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('products.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Productos</span>
                            </a>

                            <a href="{{ route('categories.index') }}"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('categories.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('categories.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Categorías</span>
                            </a>

                            <div class="mt-6 mb-3 px-4">
                                <p class="text-xs font-black text-slate-500 uppercase tracking-wider">Información de Salud</p>
                            </div>

                            <a href="{{ route('diseases.index') }}"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('diseases.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('diseases.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Enfermedades</span>
                            </a>

                            <a href="{{ route('health-properties.index') }}"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('health-properties.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('health-properties.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Propiedades Saludables</span>
                            </a>
                        @endif

                        @if($canManageOperations)
                            <div class="mt-6 mb-3 px-4">
                                <p class="text-xs font-black text-slate-500 uppercase tracking-wider">Operaciones</p>
                            </div>

                            @if($isJefa)
                                <a href="{{ route('inventory.index') }}"
                                   class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('inventory.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('inventory.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <span class="ml-3 font-semibold">Inventario</span>
                                </a>
                            @endif

                            <a href="{{ route('orders.index') }}"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('orders.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('orders.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Pedidos</span>
                            </a>
                        @endif

                        @if($isJefa || $isAdmin)
                            <div class="mt-6 mb-3 px-4">
                                <p class="text-xs font-black text-slate-500 uppercase tracking-wider">Administración</p>
                            </div>

                            <a href="{{ route('users.index') }}"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('users.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Usuarios</span>
                            </a>

                            @if($isJefa)
                                <a href="{{ route('roles.index') }}"
                                   class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('roles.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('roles.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <span class="ml-3 font-semibold">Roles</span>
                                </a>
                            @endif
                        @endif
                    </nav>

                    <!-- User Profile Section -->
                    <div class="border-t border-slate-700/50 bg-gradient-to-r from-slate-800 to-slate-900">
                        <div class="px-4 py-4">
                            <div class="flex items-center space-x-3 px-3 py-2 rounded-xl bg-slate-700/30 hover:bg-slate-700/50 transition">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-bold shadow">
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 pb-4 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 hover:bg-white/10 hover:text-white transition-all">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-semibold">Mi Perfil</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2.5 rounded-lg text-red-300 hover:bg-red-500/10 hover:text-red-200 transition-all">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="font-semibold">Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Overlay -->
                <div x-show="sidebarOpen"
                     @click="sidebarOpen = false"
                     class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     x-cloak></div>

                <!-- Mobile Sidebar -->
                <aside x-show="sidebarOpen"
                       class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white transform transition-transform duration-300 lg:hidden"
                       x-transition:enter="transition ease-out duration-300"
                       x-transition:enter-start="-translate-x-full"
                       x-transition:enter-end="translate-x-0"
                       x-transition:leave="transition ease-in duration-300"
                       x-transition:leave-start="translate-x-0"
                       x-transition:leave-end="-translate-x-full"
                       x-cloak>
                    <!-- Mobile content same as desktop sidebar -->
                    <div class="flex items-center justify-between px-6 py-5 bg-gradient-to-r from-slate-800 to-slate-900 border-b border-slate-700/50">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-black text-white">Sistema HGW</p>
                                <p class="text-xs text-slate-400">Healthy Glow Wellness</p>
                            </div>
                        </a>
                        <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <nav class="flex-1 overflow-y-auto py-6 px-4 custom-scrollbar">
                        @php
                            $user = Auth::user();
                            $isJefa = $user?->hasRole('jefa');
                            $isAdmin = $user?->hasRole('administrador');
                            $isEmpleado = $user?->hasRole('empleado');
                            $isCliente = $user?->hasRole('cliente');
                            $canManageCatalog = $isJefa || $isAdmin || $isEmpleado;
                            $canManageOperations = $isJefa || $isAdmin || $isEmpleado;
                        @endphp

                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}"
                           @click="sidebarOpen = false"
                           class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                            <div class="w-10 h-10 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <span class="ml-3 font-semibold">Dashboard</span>
                        </a>

                        @if($isCliente)
                            <!-- Catálogo para Cliente -->
                            <div class="mt-6 mb-3 px-4">
                                <p class="text-xs font-black text-slate-500 uppercase tracking-wider">Tienda</p>
                            </div>

                            <a href="{{ route('client.dashboard') }}"
                               @click="sidebarOpen = false"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('client.dashboard') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('client.dashboard') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Catálogo de Productos</span>
                            </a>

                            <a href="{{ route('client.cart') }}"
                               @click="sidebarOpen = false"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('client.cart') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('client.cart') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Mi Carrito</span>
                            </a>

                            <a href="{{ route('client.orders') }}"
                               @click="sidebarOpen = false"
                               class="flex items-center px-4 py-3 mb-1 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all group {{ request()->routeIs('client.orders') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : '' }}">
                                <div class="w-10 h-10 rounded-lg {{ request()->routeIs('client.orders') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-700' }} flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <span class="ml-3 font-semibold">Mis Pedidos</span>
                            </a>
                        @endif
                    </nav>
                </aside>

                <!-- Main Content Area -->
                <div class="flex-1 flex flex-col overflow-hidden bg-slate-50">
                    <!-- Top Header Bar -->
                    <header class="flex items-center justify-between h-20 bg-white border-b border-slate-200 px-6 shadow-sm">
                        <button @click="sidebarOpen = true" class="text-slate-600 hover:text-slate-900 lg:hidden transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        @if (isset($header))
                            <div class="text-3xl font-black text-slate-900">
                                {{ $header }}
                            </div>
                        @else
                            <div></div>
                        @endif

                        <div class="flex items-center space-x-4">
                            <div class="hidden md:flex items-center space-x-2 text-sm">
                                <div class="px-4 py-2 bg-slate-100 rounded-lg">
                                    <span class="text-slate-600 font-medium">{{ now()->locale('es')->isoFormat('D [de] MMMM, YYYY') }}</span>
                                </div>
                                <div class="px-4 py-2 bg-green-100 border border-green-300 rounded-lg">
                                    <div class="flex items-center space-x-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                        <span class="text-green-700 font-bold">Sistema Activo</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main class="flex-1 overflow-y-auto bg-slate-50 p-6 custom-scrollbar">
                        <div class="animate-fade-in">
                            {{ $slot }}
                        </div>
                    </main>

                    <!-- Footer -->
                    <footer class="bg-white border-t border-slate-200 px-6 py-4">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <p>&copy; {{ now()->year }} Sistema HGW - Healthy Glow Wellness. Todos los derechos reservados.</p>
                            <p class="font-semibold">v1.0.0</p>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
