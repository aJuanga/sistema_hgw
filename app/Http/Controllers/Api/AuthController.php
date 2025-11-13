<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use App\Models\HealthProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'allergies' => 'nullable|string',
            'diseases' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

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

            // Generar token JWT
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'user' => $user->load('roles', 'customer', 'healthProfile'),
                'token' => $token,
                'token_type' => 'bearer',
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            // Eliminar foto si se subió
            if ($profilePhotoPath) {
                Storage::disk('public')->delete($profilePhotoPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $user = auth()->user();

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'user' => $user->load('roles'),
            'token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    /**
     * Get authenticated user
     */
    public function me()
    {
        $user = auth()->user();
        
        return response()->json([
            'success' => true,
            'user' => $user->load('roles', 'healthProfile', 'customer')
        ]);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'success' => true,
            'message' => 'Logout exitoso'
        ]);
    }

    /**
     * Refresh token
     */
    public function refresh()
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());

        return response()->json([
            'success' => true,
            'token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}