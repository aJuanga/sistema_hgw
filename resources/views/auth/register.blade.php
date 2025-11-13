<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-900">Registro de Cliente</h2>
        <p class="text-sm text-slate-600 mt-2">Crea tu cuenta para hacer pedidos en Healthy Glow Wellness</p>
    </div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Nombre -->
            <div>
                <x-input-label for="name" value="Nombre *" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="given-name" placeholder="Tu nombre" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Apellidos -->
            <div>
                <x-input-label for="last_name" value="Apellidos *" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" placeholder="Tus apellidos" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Correo Electrónico (Gmail) *" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="tucorreo@gmail.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Teléfono -->
        <div>
            <x-input-label for="phone" value="Número de Celular *" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="70123456" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Alergias/Enfermedades -->
        <div>
            <x-input-label for="allergies" value="Alergias o Enfermedades (Opcional)" />
            <textarea id="allergies" name="allergies" rows="3"
                      class="block mt-1 w-full border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm"
                      placeholder="Ej: Alérgico a los frutos secos, diabético, etc.">{{ old('allergies') }}</textarea>
            <x-input-error :messages="$errors->get('allergies')" class="mt-2" />
            <p class="text-xs text-slate-500 mt-1">Esta información nos ayudará a recomendarte productos adecuados</p>
        </div>

        <!-- Foto de Perfil -->
        <div>
            <x-input-label for="profile_photo" value="Foto de Perfil (Opcional)" />
            <input id="profile_photo" type="file" name="profile_photo" accept="image/*"
                   class="block mt-1 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
            <p class="text-xs text-slate-500 mt-1">Formatos aceptados: JPG, PNG. Máximo 2MB</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Contraseña -->
            <div>
                <x-input-label for="password" value="Contraseña *" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <x-input-label for="password_confirmation" value="Confirmar Contraseña *" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex flex-col space-y-4 mt-6">
            <x-primary-button class="w-full justify-center bg-amber-600 hover:bg-amber-700">
                Crear mi cuenta
            </x-primary-button>

            <div class="text-center">
                <a class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500" href="{{ route('login') }}">
                    ¿Ya tienes cuenta? Inicia sesión aquí
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
