<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente - Healthy Grow Way</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-green-700 mb-2">Healthy Grow Way</h1>
                <p class="text-gray-600 text-lg">Registro de Nuevo Cliente</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <form action="{{ route('public.register.store') }}" method="POST">
                    @csrf

                    <!-- Datos Personales -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Datos Personales</h2>

                        <!-- Nombre Completo -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition"
                                   placeholder="Ej: Juan Pérez García"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email y Teléfono -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email') }}"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition"
                                       placeholder="ejemplo@gmail.com"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Teléfono <span class="text-red-500">*</span>
                                </label>
                                <input type="tel"
                                       name="phone"
                                       id="phone"
                                       value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition"
                                       placeholder="71234567"
                                       required>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- CI (opcional) -->
                        <div class="mb-4">
                            <label for="ci" class="block text-sm font-medium text-gray-700 mb-2">
                                Cédula de Identidad (Opcional)
                            </label>
                            <input type="text"
                                   name="ci"
                                   id="ci"
                                   value="{{ old('ci') }}"
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition"
                                   placeholder="Ej: 12345678 LP">
                            @error('ci')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dirección/Ubicación -->
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Dirección / Zona donde vive <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address"
                                      id="address"
                                      rows="2"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition"
                                      placeholder="Ej: Zona Sur, Calle 21 #456, La Paz"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información de Salud -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Información de Salud</h2>
                        <p class="text-sm text-gray-600 mb-4">Esta información nos ayuda a ofrecerte mejores recomendaciones de productos</p>

                        <!-- Enfermedades -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Enfermedades o Condiciones de Salud (Opcional)
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4">
                                @forelse($diseases as $disease)
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="diseases[]"
                                               id="disease_{{ $disease->id }}"
                                               value="{{ $disease->id }}"
                                               {{ in_array($disease->id, old('diseases', [])) ? 'checked' : '' }}
                                               class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                        <label for="disease_{{ $disease->id }}" class="ml-2 text-sm text-gray-700">
                                            {{ $disease->name }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">No hay enfermedades disponibles</p>
                                @endforelse
                            </div>
                            @error('diseases')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alergias -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alergias Alimentarias (Opcional)
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4">
                                @forelse($allergies as $allergy)
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="allergies[]"
                                               id="allergy_{{ $allergy->id }}"
                                               value="{{ $allergy->id }}"
                                               {{ in_array($allergy->id, old('allergies', [])) ? 'checked' : '' }}
                                               class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                        <label for="allergy_{{ $allergy->id }}" class="ml-2 text-sm text-gray-700">
                                            {{ $allergy->name }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">No hay alergias disponibles</p>
                                @endforelse
                            </div>
                            @error('allergies')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notas adicionales -->
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notas Adicionales (Opcional)
                            </label>
                            <textarea name="notes"
                                      id="notes"
                                      rows="3"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition"
                                      placeholder="Cualquier información adicional que consideres importante...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-between pt-6 border-t">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 transition">
                            ← Volver al inicio
                        </a>
                        <button type="submit"
                                class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition shadow-lg">
                            Registrarme
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer info -->
            <div class="text-center mt-6 text-gray-600 text-sm">
                <p>Al registrarte, aceptas que tus datos sean utilizados para mejorar tu experiencia de compra</p>
            </div>
        </div>
    </div>
</body>
</html>
