<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Registro de Cliente</h2>
        <p class="text-sm text-gray-600 mt-1">Completa el formulario para crear tu cuenta</p>
    </div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Name -->
            <div>
                <x-input-label for="name" value="Nombre *" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="given-name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Last Name -->
            <div>
                <x-input-label for="last_name" value="Apellidos *" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Correo Electrónico (Gmail) *" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" value="Número de Teléfono *" />
                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="Ej: +52 123 456 7890" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <!-- Password -->
            <div>
                <x-input-label for="password" value="Contraseña *" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" value="Confirmar Contraseña *" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Profile Photo -->
        <div class="mt-4">
            <x-input-label for="profile_photo" value="Foto de Perfil" />
            <input id="profile_photo" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="profile_photo" accept="image/*" />
            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Opcional. Formatos: JPG, PNG, GIF (máx. 2MB)</p>
        </div>

        <!-- Allergies -->
        <div class="mt-4">
            <x-input-label for="allergies" value="Alergias" />
            <textarea id="allergies" name="allergies" rows="2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Indica si tienes alguna alergia alimentaria">{{ old('allergies') }}</textarea>
            <x-input-error :messages="$errors->get('allergies')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Opcional. Ej: lactosa, gluten, nueces, etc.</p>
        </div>

        <!-- Diseases -->
        <div class="mt-4">
            <x-input-label for="diseases" value="Enfermedades o Condiciones de Salud" />
            <textarea id="diseases" name="diseases" rows="2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Indica si tienes alguna enfermedad o condición de salud relevante">{{ old('diseases') }}</textarea>
            <x-input-error :messages="$errors->get('diseases')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Opcional. Ej: diabetes, hipertensión, celiaquía, etc.</p>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                ¿Ya tienes cuenta? Inicia sesión
            </a>

            <x-primary-button class="ms-4">
                Registrarse
            </x-primary-button>
        </div>

        <p class="text-xs text-gray-500 mt-4 text-center">
            Los campos marcados con * son obligatorios
        </p>
    </form>
</x-guest-layout>
