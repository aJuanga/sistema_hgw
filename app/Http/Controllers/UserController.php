<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Filtro por rol
        if ($request->has('role') && $request->role != '') {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('slug', $request->role);
            });
        }

        // Filtro por búsqueda
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhere('phone', 'ILIKE', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::where('is_active', true)->get();

        return view('jefa.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Excluir el rol de Jefa - solo puede haber una Jefa en el sistema
        $roles = Role::where('is_active', true)
            ->where('slug', '!=', 'jefa')
            ->get();
        return view('jefa.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Obtener el rol seleccionado
        $role = Role::find($request->role_id);

        // Validación base
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'role_id' => ['required', 'exists:roles,id'],
            'is_active' => ['boolean'],
        ];

        // Agregar validación de CI y dirección para Jefa, Administrador y Empleado
        if ($role && in_array($role->slug, ['jefa', 'administrador', 'empleado'])) {
            $rules['ci'] = ['required', 'string', 'max:20'];
            $rules['address'] = ['required', 'string', 'max:500'];
        }

        $validated = $request->validate($rules);

        // Crear usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'ci' => $validated['ci'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        // Manejar foto de perfil
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
            $user->save();
        }

        // Asignar rol
        $user->roles()->attach($validated['role_id']);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles', 'orders', 'customer');

        return view('jefa.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $user->load('roles');

        // Si el usuario es la Jefa, mostrar todos los roles (incluyendo Jefa)
        // Si no es Jefa, excluir el rol de Jefa de las opciones
        if ($user->isJefa()) {
            $roles = Role::where('is_active', true)->get();
        } else {
            $roles = Role::where('is_active', true)
                ->where('slug', '!=', 'jefa')
                ->get();
        }

        return view('jefa.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Obtener el rol seleccionado
        $role = Role::find($request->role_id);

        // ⚠️ PROTECCIÓN: No se puede asignar el rol de Jefa a otro usuario
        // Solo la Jefa puede mantener su propio rol de Jefa
        if ($role && $role->slug === 'jefa' && !$user->isJefa()) {
            return redirect()->route('users.index')
                ->with('error', 'No se puede asignar el rol de Jefa a otro usuario. Solo puede haber una Jefa en el sistema.');
        }

        // Validación base
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'role_id' => ['required', 'exists:roles,id'],
            'is_active' => ['boolean'],
        ];

        // Agregar validación de CI y dirección para Jefa, Administrador y Empleado
        if ($role && in_array($role->slug, ['jefa', 'administrador', 'empleado'])) {
            $rules['ci'] = ['required', 'string', 'max:20'];
            $rules['address'] = ['required', 'string', 'max:500'];
        }

        $validated = $request->validate($rules);

        // Actualizar datos básicos
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->ci = $validated['ci'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->is_active = $request->has('is_active') ? true : false;

        // Actualizar contraseña solo si se proporcionó
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Manejar foto de perfil
        if ($request->hasFile('profile_photo')) {
            // Eliminar foto anterior si existe
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        // Actualizar rol
        $user->roles()->sync([$validated['role_id']]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // ⚠️ PROTECCIÓN: No se puede eliminar a la Jefa
        if ($user->isJefa()) {
            return redirect()->route('users.index')
                ->with('error', 'No se puede eliminar a la Jefa. Este usuario está protegido.');
        }

        // Verificar si el usuario tiene pedidos asociados
        if ($user->orders()->count() > 0) {
            return redirect()->route('users.index')
                ->with('error', 'No se puede eliminar este usuario porque tiene pedidos asociados. Total de pedidos: ' . $user->orders()->count());
        }

        // Verificar si el usuario tiene otras relaciones importantes
        $hasRelations = false;
        $relationMessage = '';

        if ($user->customer && $user->customer->exists()) {
            $hasRelations = true;
            $relationMessage .= 'perfil de cliente, ';
        }

        if ($user->healthProfile && $user->healthProfile->exists()) {
            $hasRelations = true;
            $relationMessage .= 'perfil de salud, ';
        }

        if ($hasRelations) {
            $relationMessage = rtrim($relationMessage, ', ');
            return redirect()->route('users.index')
                ->with('error', 'No se puede eliminar este usuario porque tiene datos asociados: ' . $relationMessage);
        }

        // Eliminar foto de perfil si existe
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Eliminar el usuario
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Toggle user active status (activate/deactivate).
     */
    public function toggleStatus(User $user)
    {
        // ⚠️ PROTECCIÓN: No se puede desactivar a la Jefa
        if ($user->isJefa()) {
            return redirect()->route('users.index')
                ->with('error', 'No se puede desactivar a la Jefa. Este usuario está protegido.');
        }

        // Cambiar el estado
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activado' : 'desactivado';

        return redirect()->route('users.index')
            ->with('success', "Usuario {$status} exitosamente.");
    }
}
