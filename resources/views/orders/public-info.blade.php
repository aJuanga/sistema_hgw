<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Grow Way - Cafetería Wellness</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-bold gradient-text">HGW</span>
                    <span class="text-gray-600 text-sm font-medium hidden sm:inline">Healthy Grow Way</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('client.dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                            Ver Catálogo
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900">
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('orders.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                            Registrarme
                        </a>
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-green-50 to-green-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full shadow-2xl mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-4">
                <span class="gradient-text">Healthy Grow Way</span>
            </h1>
            <p class="text-2xl text-gray-700 mb-6">Tu Cafetería Wellness</p>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Donde cada bebida y alimento está diseñado para nutrir tu cuerpo y elevar tu espíritu
            </p>
        </div>
    </section>

    <!-- Nuestra Cafetería -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">Nuestra Cafetería</h2>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-6 shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Bebidas Funcionales</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Smoothies energizantes, cafés orgánicos, jugos naturales y tés herbales que nutren tu cuerpo
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-gradient-to-br from-amber-50 to-white rounded-xl p-6 shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Snacks Saludables</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Bocadillos nutritivos, bowls energéticos y postres sin azúcar refinada para tu bienestar
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-6 shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Ingredientes Orgánicos</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Solo usamos ingredientes naturales, orgánicos y de origen sostenible para tu salud
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Beneficios Saludables -->
    <section class="py-16 bg-gradient-to-br from-green-50 to-green-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-4">¿Por qué HGW es Saludable?</h2>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Cada producto está diseñado con propósito: mejorar tu energía, fortalecer tu sistema inmune y promover tu bienestar integral
            </p>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-3">🌱</div>
                    <h3 class="font-bold text-gray-900 mb-2">100% Natural</h3>
                    <p class="text-sm text-gray-600">Sin conservantes ni químicos artificiales</p>
                </div>

                <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-3">🚫</div>
                    <h3 class="font-bold text-gray-900 mb-2">Sin Azúcar Refinada</h3>
                    <p class="text-sm text-gray-600">Endulzado con stevia y miel natural</p>
                </div>

                <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-3">💪</div>
                    <h3 class="font-bold text-gray-900 mb-2">Alto en Nutrientes</h3>
                    <p class="text-sm text-gray-600">Vitaminas, minerales y antioxidantes</p>
                </div>

                <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-3">⚡</div>
                    <h3 class="font-bold text-gray-900 mb-2">Energía Natural</h3>
                    <p class="text-sm text-gray-600">Combate la fatiga sin cafeína excesiva</p>
                </div>

                <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-3">🥗</div>
                    <h3 class="font-bold text-gray-900 mb-2">Bajo en Calorías</h3>
                    <p class="text-sm text-gray-600">Ideal para control de peso saludable</p>
                </div>

                <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-3">🛡️</div>
                    <h3 class="font-bold text-gray-900 mb-2">Fortalece Inmunidad</h3>
                    <p class="text-sm text-gray-600">Con superalimentos y probióticos</p>
                </div>

                <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-3">🧘</div>
                    <h3 class="font-bold text-gray-900 mb-2">Reduce Estrés</h3>
                    <p class="text-sm text-gray-600">Ingredientes adaptógenos calmantes</p>
                </div>

                <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition">
                    <div class="text-4xl mb-3">🌿</div>
                    <h3 class="font-bold text-gray-900 mb-2">Vegano & Sin Gluten</h3>
                    <p class="text-sm text-gray-600">Opciones para todas las dietas</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Horarios -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">Horarios de Atención</h2>

            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-xl p-8">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Lunes a Viernes</h3>
                            <p class="text-gray-600">7:00 AM - 8:00 PM</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Sábados</h3>
                            <p class="text-gray-600">8:00 AM - 7:00 PM</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Domingos</h3>
                            <p class="text-gray-600">9:00 AM - 5:00 PM</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Feriados</h3>
                            <p class="text-gray-600">Horarios especiales</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-gray-600 mb-4">
                        <svg class="w-5 h-5 inline mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Zona Sur, La Paz - Bolivia
                    </p>
                    <p class="text-gray-600">
                        <svg class="w-5 h-5 inline mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        WhatsApp: +591 7123-4567
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Misión y Visión -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-8 shadow-lg">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <h3 class="text-3xl font-bold text-green-700">Nuestra Misión</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        Proporcionar alimentos y bebidas saludables que mejoren la calidad de vida de nuestros clientes,
                        utilizando ingredientes naturales y recetas sin azúcar refinada, en un ambiente acogedor y sostenible.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-white rounded-2xl p-8 shadow-lg">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <h3 class="text-3xl font-bold text-amber-700">Nuestra Visión</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        Ser la cafetería wellness de referencia, reconocida por transformar vidas a través de la nutrición
                        consciente y el compromiso con el bienestar integral de cada persona.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-16 bg-gradient-to-r from-green-600 to-green-700 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @auth
                <h2 class="text-4xl font-bold mb-4">¡Bienvenido a HGW!</h2>
                <p class="text-xl mb-8 text-green-100">
                    Explora nuestro catálogo de productos saludables diseñados especialmente para ti
                </p>
                <a href="{{ route('client.dashboard') }}"
                   class="inline-block px-12 py-4 bg-white text-green-600 font-bold text-lg rounded-xl shadow-2xl hover:bg-gray-100 transition transform hover:scale-105">
                    Ver Catálogo de Productos
                </a>
            @else
                <h2 class="text-4xl font-bold mb-4">¿Listo para comenzar tu viaje wellness?</h2>
                <p class="text-xl mb-8 text-green-100">
                    Regístrate ahora y recibe recomendaciones personalizadas según tu perfil de salud
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('orders.create') }}"
                       class="inline-block px-12 py-4 bg-white text-green-600 font-bold text-lg rounded-xl shadow-2xl hover:bg-gray-100 transition transform hover:scale-105">
                        Registrarme Ahora
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-block px-12 py-4 bg-green-800 text-white border-2 border-white font-bold text-lg rounded-xl shadow-2xl hover:bg-green-900 transition transform hover:scale-105">
                        Ya tengo cuenta
                    </a>
                </div>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm">
                &copy; {{ date('Y') }} Healthy Grow Way. Todos los derechos reservados.
            </p>
            <p class="text-xs mt-2 text-gray-400">
                Transformando vidas, una bebida saludable a la vez ✨
            </p>
        </div>
    </footer>
</body>
</html>
