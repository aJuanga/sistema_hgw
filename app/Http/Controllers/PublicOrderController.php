<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\HealthProfile;
use App\Models\Disease;
use App\Models\Allergy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PublicOrderController extends Controller
{
    /**
     * Mostrar formulario público de registro de cliente
     */
    public function showRegisterForm()
    {
        $diseases = Disease::where('is_active', true)->orderBy('name')->get();
        $allergies = Allergy::where('is_active', true)->orderBy('name')->get();

        return view('public.register-client', compact('diseases', 'allergies'));
    }

    /**
     * Registrar un nuevo cliente desde formulario público
     */
    public function registerClient(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'ci' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'diseases' => 'nullable|array',
            'diseases.*' => 'exists:diseases,id',
            'allergies' => 'nullable|array',
            'allergies.*' => 'exists:allergies,id',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser válido',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'phone.required' => 'El teléfono es obligatorio',
            'address.required' => 'La dirección/ubicación es obligatoria',
        ]);

        DB::beginTransaction();

        try {
            // Crear usuario con contraseña temporal aleatoria
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(16)), // Contraseña temporal aleatoria
                'phone' => $validated['phone'],
                'ci' => $validated['ci'] ?? null,
                'address' => $validated['address'],
                'is_active' => true,
            ]);

            // Asignar rol de cliente
            $clientRole = Role::where('slug', 'cliente')->first();
            if ($clientRole) {
                $user->roles()->attach($clientRole->id);
            }

            // Crear perfil de salud si hay enfermedades o alergias
            if (!empty($validated['diseases']) || !empty($validated['allergies'])) {
                $healthProfile = HealthProfile::create([
                    'user_id' => $user->id,
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Asociar enfermedades
                if (!empty($validated['diseases'])) {
                    $healthProfile->diseases()->attach($validated['diseases']);
                }

                // Asociar alergias
                if (!empty($validated['allergies'])) {
                    $healthProfile->allergies()->attach($validated['allergies']);
                }
            }

            DB::commit();

            return redirect()->route('public.register')
                ->with('success', '¡Registro exitoso! Tu cuenta ha sido creada. Pronto te contactaremos para completar tu pedido.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al registrar: ' . $e->getMessage());
        }
    }
}
