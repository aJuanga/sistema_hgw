<x-jefa-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-900 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Editar Usuario</h2>
                        <p class="mt-1 text-sm text-gray-600">Actualiza la información del usuario</p>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Foto actual -->
                        @if($user->profile_photo)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Actual</label>
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
                            </div>
                        @endif

                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Correo Electrónico <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Teléfono
                            </label>
                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                value="{{ old('phone', $user->phone) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                            >
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contraseña (opcional en edición) -->
                        <div class="border-t pt-4">
                            <p class="text-sm text-gray-600 mb-4">Deja estos campos vacíos si no deseas cambiar la contraseña</p>

                            <div class="space-y-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nueva Contraseña
                                    </label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                    >
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                        Confirmar Nueva Contraseña
                                    </label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Rol -->
                        <div>
                            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Rol <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="role_id"
                                id="role_id"
                                required
                                onchange="toggleStaffFields()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('role_id') border-red-500 @enderror"
                            >
                                <option value="">Seleccionar rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" data-slug="{{ $role->slug }}" {{ old('role_id', $user->roles->first()?->id) == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campos adicionales para Jefa, Administrador y Empleado -->
                        <div id="staff-fields" style="display: none;" class="col-span-2 space-y-4 border-t pt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Información Adicional (CI y Dirección)</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- CI -->
                                <div>
                                    <label for="ci" class="block text-sm font-medium text-gray-700 mb-1">
                                        Cédula de Identidad (CI) <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="ci"
                                        id="ci"
                                        value="{{ old('ci', $user->ci) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('ci') border-red-500 @enderror"
                                    >
                                    @error('ci')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Zona donde vive -->
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                        Zona donde vive <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="address"
                                        id="address"
                                        value="{{ old('address', $user->address) }}"
                                        placeholder="Ej: Zona Sur, Calacoto"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('address') border-red-500 @enderror"
                                    >
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Foto de Perfil -->
                        <div>
                            <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-1">
                                Cambiar Foto de Perfil
                            </label>
                            <input
                                type="file"
                                name="profile_photo"
                                id="profile_photo"
                                accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('profile_photo') border-red-500 @enderror"
                            >
                            <p class="mt-1 text-xs text-gray-500">Formatos: JPG, PNG. Tamaño máximo: 2MB</p>
                            @error('profile_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado Activo -->
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                name="is_active"
                                id="is_active"
                                value="1"
                                {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                            >
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                Usuario activo
                            </label>
                        </div>

                        @if($user->isJefa())
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-purple-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-purple-900">Usuario Protegido</p>
                                        <p class="text-xs text-purple-700 mt-1">Este usuario tiene el rol de Jefa y no puede ser eliminado del sistema.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Botones -->
                    <div class="mt-8 flex gap-3">
                        <button
                            type="submit"
                            class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-md transition duration-150"
                        >
                            Actualizar Usuario
                        </button>
                        <a
                            href="{{ route('users.index') }}"
                            class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition duration-150"
                        >
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleStaffFields() {
            const roleSelect = document.getElementById('role_id');
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const roleSlug = selectedOption.getAttribute('data-slug');
            const staffFields = document.getElementById('staff-fields');
            const ciInput = document.getElementById('ci');
            const addressInput = document.getElementById('address');

            // Mostrar campos si es jefa, administrador o empleado
            if (roleSlug === 'jefa' || roleSlug === 'administrador' || roleSlug === 'empleado') {
                staffFields.style.display = 'block';
                ciInput.required = true;
                addressInput.required = true;
            } else {
                staffFields.style.display = 'none';
                ciInput.required = false;
                addressInput.required = false;
            }
        }

        // Ejecutar al cargar la página para mostrar los campos correctos
        document.addEventListener('DOMContentLoaded', function() {
            toggleStaffFields();
        });
    </script>
</x-jefa-layout>
