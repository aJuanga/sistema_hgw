<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Sistema HGW</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
                <!-- Sidebar -->
                <aside class="w-64 bg-gray-800 text-white flex-shrink-0 hidden md:flex md:flex-col">
                    <!-- Logo -->
                    <div class="flex items-center justify-center h-16 bg-gray-900">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold">
                            Sistema HGW
                        </a>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 overflow-y-auto py-4">
                        @php
                            $user = Auth::user();
                            $canManageCatalog = $user?->hasAnyRole(['jefa', 'administrador']);
                            $canManageOperations = $user?->hasAnyRole(['jefa', 'administrador', 'empleado']);
                            $catalogLabel = $canManageCatalog ? 'Gestión de Productos' : 'Catálogo';
                        @endphp

                        <a href="{{ route('dashboard') }}"
                           class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>

                        <div class="px-6 py-2 text-xs font-semibold text-gray-400 uppercase">
                            {{ $catalogLabel }}
                        </div>

                        @if($canManageCatalog)
                            <a href="{{ route('products.index') }}"
                               class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('products.*') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                Productos
                            </a>
                        @else
                            <a href="{{ route('client.dashboard') }}"
                               class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('client.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                Catálogo
                            </a>
                        @endif

                        @if($canManageCatalog)
                            <a href="{{ route('categories.index') }}"
                               class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('categories.*') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Categorías
                            </a>

                            <div class="px-6 py-2 text-xs font-semibold text-gray-400 uppercase mt-4">
                                Salud
                            </div>

                            <a href="{{ route('diseases.index') }}"
                               class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('diseases.*') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Enfermedades
                            </a>

                            <a href="{{ route('health-properties.index') }}"
                               class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('health-properties.*') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Propiedades Saludables
                            </a>
                        @endif

                        @if($canManageOperations)
                            <div class="px-6 py-2 text-xs font-semibold text-gray-400 uppercase mt-4">
                                Operaciones
                            </div>

                            <a href="{{ route('orders.index') }}"
                               class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('orders.*') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                Pedidos
                            </a>
                        @endif
                    </nav>

                    <!-- User Menu -->
                    <div class="border-t border-gray-700">
                        <div class="px-6 py-4">
                            <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Mobile sidebar -->
                <div x-show="sidebarOpen"
                     @click="sidebarOpen = false"
                     class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden"
                     x-cloak></div>

                <aside x-show="sidebarOpen"
                       class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 text-white transform transition-transform duration-300 md:hidden"
                       x-cloak>
                    <!-- Same navigation as desktop -->
                    <div class="flex items-center justify-between h-16 bg-gray-900 px-6">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold">Sistema HGW</a>
                        <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <nav class="flex-1 overflow-y-auto py-4">
                        <!-- Copy navigation links here -->
                    </nav>
                </aside>

                <!-- Main Content -->
                <div class="flex-1 flex flex-col overflow-hidden">
                    <!-- Top bar -->
                    <header class="flex items-center justify-between h-16 bg-white border-b border-gray-200 px-6">
                        <button @click="sidebarOpen = true" class="text-gray-500 md:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        @if (isset($header))
                            <div class="text-2xl font-semibold text-gray-800">
                                {{ $header }}
                            </div>
                        @endif
                        <div></div>
                    </header>

                    <!-- Page Content -->
                    <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
