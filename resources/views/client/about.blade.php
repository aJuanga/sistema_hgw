@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Healthy Glow Wellness') }} - Bienvenido</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
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

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-pattern {
            background-color: #ffffff;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(245, 158, 11, 0.05) 0%, transparent 50%);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <span class="text-2xl font-bold gradient-text">HGW</span>
                    </div>
                    <span class="text-gray-600 text-sm font-medium hidden sm:inline">Healthy Glow Wellness</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm text-gray-600 hidden sm:inline">Hola, <span class="font-semibold text-gray-900">{{ $user->name }}</span></span>
                        <a href="{{ route('client.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-emerald-300 rounded-lg text-sm font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Ir al Catálogo
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg text-sm font-medium text-white hover:from-emerald-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Registrarse
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-pattern min-h-screen flex items-center justify-center py-20 px-4">
        <div class="max-w-5xl mx-auto text-center">
            <!-- Logo/Icon -->
            <div class="mb-8 animate-fade-in opacity-0">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full shadow-2xl mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </div>
                <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-4">
                    <span class="gradient-text">Healthy Glow</span>
                    <br>
                    <span class="text-gray-700">Wellness</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 font-light max-w-2xl mx-auto">
                    Tu cafetería wellness que ilumina tu día con salud y sabor
                </p>
            </div>

            <!-- Welcome Message -->
            <div class="mb-12 animate-fade-in-up opacity-0 delay-100">
                <p class="text-lg text-gray-700 max-w-3xl mx-auto leading-relaxed">
                    Bienvenido a <strong class="font-semibold text-emerald-600">Healthy Glow Wellness</strong>,
                    donde cada bebida y alimento está diseñado para nutrir tu cuerpo y elevar tu espíritu.
                    Creemos que la verdadera salud comienza con lo que consumes.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-8 mb-16 max-w-4xl mx-auto">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 animate-fade-in-up opacity-0 delay-200">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ingredientes Naturales</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Seleccionamos cuidadosamente ingredientes orgánicos y de origen sostenible para cada preparación.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 animate-fade-in-up opacity-0 delay-300">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Recetas Funcionales</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Bebidas energéticas, batidos nutritivos y snacks diseñados para potenciar tu bienestar.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 animate-fade-in-up opacity-0 delay-400">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Salud Integral</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Enfocados en tu bienestar físico y mental, cada producto está pensado para tu salud integral.
                    </p>
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="grid md:grid-cols-2 gap-8 mb-16 max-w-4xl mx-auto">
                <div class="bg-gradient-to-br from-emerald-50 to-white rounded-2xl p-8 text-left shadow-md animate-fade-in-up opacity-0 delay-400">
                    <h3 class="text-2xl font-bold text-emerald-700 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Nuestra Misión
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        Proporcionar alimentos y bebidas saludables que mejoren la calidad de vida de nuestros clientes,
                        utilizando ingredientes naturales y recetas sin azúcar refinada, en un ambiente acogedor y sostenible.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-white rounded-2xl p-8 text-left shadow-md animate-fade-in-up opacity-0 delay-500">
                    <h3 class="text-2xl font-bold text-amber-700 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Nuestra Visión
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        Ser la cafetería wellness de referencia, reconocida por transformar vidas a través de la nutrición
                        consciente y el compromiso con el bienestar integral de cada persona.
                    </p>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="animate-fade-in-up opacity-0 delay-500">
                @auth
                    <a href="{{ route('client.dashboard') }}" class="group inline-flex items-center px-12 py-5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white text-xl font-bold rounded-2xl shadow-2xl shadow-emerald-500/50 transition-all duration-300 transform hover:scale-105 hover:shadow-emerald-600/60">
                        <svg class="w-6 h-6 mr-3 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Ver Catálogo
                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <p class="mt-4 text-sm text-gray-500">
                        Explora nuestro menú de bebidas funcionales y snacks saludables
                    </p>
                @else
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('login') }}" class="group inline-flex items-center px-12 py-5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white text-xl font-bold rounded-2xl shadow-2xl shadow-emerald-500/50 transition-all duration-300 transform hover:scale-105 hover:shadow-emerald-600/60">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Iniciar Sesión
                            <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="{{ route('register') }}" class="group inline-flex items-center px-12 py-5 bg-white border-2 border-emerald-500 hover:bg-emerald-50 text-emerald-600 text-xl font-bold rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Crear Cuenta
                            <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">
                        Únete a nuestra comunidad wellness y comienza tu viaje hacia una vida más saludable
                    </p>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-600 text-sm">
                &copy; {{ date('Y') }} Healthy Glow Wellness. Todos los derechos reservados.
            </p>
            <p class="text-gray-500 text-xs mt-2">
                Transformando vidas, una bebida saludable a la vez ✨
            </p>
        </div>
    </footer>
</body>
</html>
