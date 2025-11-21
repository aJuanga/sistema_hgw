<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Panel Ejecutivo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-amber-50 via-white to-emerald-50">
        <div class="min-h-screen">
            <!-- Sidebar -->
            <aside
                class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-emerald-900 via-emerald-800 to-amber-900 border-r border-emerald-700 transform transition-transform duration-200 ease-in-out lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            >
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-6 border-b border-emerald-700 bg-emerald-950/50">
                    <a href="{{ route('jefa.dashboard') }}" class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-900/50">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <span class="ml-3 text-lg font-bold text-white">HGW Ejecutivo</span>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-emerald-300 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- User Info -->
                <div class="px-6 py-4 border-b border-emerald-700 bg-emerald-950/30">
                    <div class="flex items-center">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover shadow-lg border-2 border-amber-400">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-emerald-200">Jefa - Acceso Total</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('jefa.dashboard') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('jefa.dashboard') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard Ejecutivo
                    </a>

                    <div class="pt-4 mt-4 border-t border-emerald-700">
                        <p class="px-4 text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-2">Catálogo</p>

                        <a href="{{ route('products.index') }}"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('products.*') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Productos
                        </a>

                        <a href="{{ route('categories.index') }}"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('categories.*') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Categorías
                        </a>
                    </div>

                    <div class="pt-4 mt-4 border-t border-emerald-700">
                        <p class="px-4 text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-2">Salud & Bienestar</p>

                        <a href="{{ route('diseases.index') }}"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('diseases.*') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Enfermedades
                        </a>

                        <a href="{{ route('health-properties.index') }}"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('health-properties.*') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Propiedades Saludables
                        </a>
                    </div>

                    <div class="pt-4 mt-4 border-t border-emerald-700">
                        <p class="px-4 text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-2">Operaciones</p>

                        <a href="{{ route('inventory.index') }}"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('inventory.*') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Inventario
                        </a>

                        <a href="{{ route('orders.index') }}"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('orders.*') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Pedidos
                        </a>
                    </div>

                    <div class="pt-4 mt-4 border-t border-emerald-700">
                        <p class="px-4 text-xs font-semibold text-amber-400 uppercase tracking-wider mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Exclusivo Jefa
                        </p>

                        <a href="{{ route('users.index') }}"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-amber-600 to-emerald-600 text-white shadow-lg' : 'text-amber-100 hover:bg-gradient-to-r hover:from-amber-700 hover:to-emerald-700' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Gestión de Usuarios
                        </a>

                        <a href="{{ route('reports.index') }}"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-amber-600 to-emerald-600 text-white shadow-lg' : 'text-amber-100 hover:bg-gradient-to-r hover:from-amber-700 hover:to-emerald-700' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Reportes & Análisis
                        </a>
                    </div>

                    <div class="pt-4 mt-4 border-t border-emerald-700">
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('profile.edit') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Mi Perfil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-medium text-emerald-100 rounded-xl transition hover:bg-emerald-800">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </nav>
            </aside>

            <!-- Overlay para móvil -->
            <div
                x-show="sidebarOpen"
                @click="sidebarOpen = false"
                x-transition:enter="transition-opacity ease-linear duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-40 bg-gray-900 bg-opacity-75 lg:hidden"
                style="display: none;"
            ></div>

            <!-- Main Content -->
            <div class="lg:pl-64">
                <!-- Top bar móvil -->
                <div class="sticky top-0 z-30 flex items-center h-16 px-4 bg-white border-b border-gray-200 lg:hidden shadow-sm">
                    <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <span class="ml-4 text-lg font-bold bg-gradient-to-r from-emerald-600 to-amber-600 bg-clip-text text-transparent">Panel Ejecutivo</span>
                </div>

                <!-- Page Content -->
                <main class="p-6 lg:p-8">
                    <!-- Page Header -->
                    @if (isset($header))
                        <header class="mb-8">
                            {{ $header }}
                        </header>
                    @endif

                    <!-- Page Content -->
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
