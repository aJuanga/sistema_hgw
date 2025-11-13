<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use App\Models\HealthProfile;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'allergies' => ['nullable', 'string'],
            'diseases' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        try {
            // Procesar foto de perfil si existe
            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            }

            // Crear usuario
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'profile_photo' => $profilePhotoPath,
                'is_active' => true,
            ]);

            // Asignar rol de Cliente por defecto
            $clienteRole = Role::where('name', 'Cliente')->orWhere('slug', 'cliente')->first();
            if ($clienteRole) {
                $user->roles()->attach($clienteRole);
            }

            // Crear perfil de cliente
            $customer = Customer::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'customer_type' => 'regular',
                'accepts_promotions' => true,
            ]);

            // Crear perfil de salud si hay alergias o enfermedades
            if ($request->filled('allergies') || $request->filled('diseases')) {
                $healthNotes = [];

                if ($request->filled('allergies')) {
                    $healthNotes[] = "Alergias: " . $request->allergies;
                }

                if ($request->filled('diseases')) {
                    $healthNotes[] = "Enfermedades: " . $request->diseases;
                }

                HealthProfile::create([
                    'user_id' => $user->id,
                    'customer_id' => $customer->id,
                    'notes' => implode("\n", $healthNotes),
                ]);
            }

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            // Redirigir a clientes al portal de clientes
            if ($user->isCliente()) {
                return redirect('/client/dashboard')->with('success', '¡Registro exitoso! Bienvenido a nuestro sistema.');
            }

            return redirect(RouteServiceProvider::HOME)->with('success', '¡Registro exitoso! Bienvenido a nuestro sistema.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Eliminar foto si se subió
            if ($profilePhotoPath) {
                Storage::disk('public')->delete($profilePhotoPath);
            }

            return back()->withInput()->withErrors(['error' => 'Error al registrar usuario. Por favor, intenta nuevamente.']);
        }
    }
}
