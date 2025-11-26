<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente - Healthy Grow Way</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-green-700 mb-2">Healthy Grow Way</h1>
                <p class="text-gray-600">Registro de Nuevo Cliente</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf
                    <input type="hidden" name="new_client" value="1">

                    <!-- Datos del Cliente -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Datos del Cliente</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="client_name" value="{{ old('client_name') }}"
                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                                       placeholder="Ej: Juan Pérez" required>
                                @error('client_name')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="client_email" value="{{ old('client_email') }}"
                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                                       placeholder="ejemplo@gmail.com" required>
                                @error('client_email')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Teléfono <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="client_phone" value="{{ old('client_phone') }}"
                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                                       placeholder="71234567" required>
                                @error('client_phone')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CI -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    CI (Opcional)
                                </label>
                                <input type="text" name="client_ci" value="{{ old('client_ci') }}"
                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                                       placeholder="12345678 LP">
                                @error('client_ci')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Dirección / Ubicación <span class="text-red-500">*</span>
                            </label>
                            <textarea name="client_address" rows="2"
                                      class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                                      placeholder="Ej: Zona Sur, Calle 21, La Paz" required>{{ old('client_address') }}</textarea>
                            @error('client_address')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Enfermedades -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Enfermedades o Condiciones (Opcional)
                            </label>
                            <div class="border rounded-lg p-3 max-h-40 overflow-y-auto bg-gray-50">
                                <div class="grid grid-cols-2 gap-2">
                                    @forelse($diseases as $disease)
                                        <label class="flex items-center text-sm">
                                            <input type="checkbox" name="client_diseases[]" value="{{ $disease->id }}"
                                                   {{ in_array($disease->id, old('client_diseases', [])) ? 'checked' : '' }}
                                                   class="mr-2 text-green-600 focus:ring-green-500">
                                            {{ $disease->name }}
                                        </label>
                                    @empty
                                        <p class="text-gray-500 text-sm col-span-2">No hay enfermedades disponibles</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Alergias -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Alergias Alimentarias (Opcional)
                            </label>
                            <div class="border rounded-lg p-3 max-h-40 overflow-y-auto bg-gray-50">
                                <div class="grid grid-cols-2 gap-2">
                                    @forelse($allergies as $allergy)
                                        <label class="flex items-center text-sm">
                                            <input type="checkbox" name="client_allergies[]" value="{{ $allergy->id }}"
                                                   {{ in_array($allergy->id, old('client_allergies', [])) ? 'checked' : '' }}
                                                   class="mr-2 text-green-600 focus:ring-green-500">
                                            {{ $allergy->name }}
                                        </label>
                                    @empty
                                        <p class="text-gray-500 text-sm col-span-2">No hay alergias disponibles</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Notas -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Notas o Comentarios Adicionales (Opcional)
                        </label>
                        <textarea name="notes" rows="3"
                                  class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                                  placeholder="Cualquier información adicional...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between items-center pt-4 border-t">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">
                            ← Volver al inicio
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 shadow-lg">
                            Registrarme
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-4 text-gray-600 text-sm">
                <p>Al registrarte, podrás realizar pedidos y recibir recomendaciones personalizadas</p>
            </div>
        </div>
    </div>

</body>
</html>
