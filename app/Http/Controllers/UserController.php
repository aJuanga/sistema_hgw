<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $query = User::with('roles');

        // Si es Admin, solo mostrar Empleado y Cliente
        if (auth()->user()->hasRole('administrador') && !auth()->user()->hasRole('jefa')) {
            $query->whereHas('roles', function ($q) {
                $q->whereIn('slug', ['empleado', 'cliente']);
            });
        }

        $users = $query->latest()->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $query = Role::where('is_active', true);

        // Si es Admin, solo permitir crear Empleado y Cliente
        if (auth()->user()->hasRole('administrador') && !auth()->user()->hasRole('jefa')) {
            $query->whereIn('slug', ['empleado', 'cliente']);
        }

        $roles = $query->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'boolean',
        ]);

        // Si es Admin, verificar que solo cree Empleado o Cliente
        if (auth()->user()->hasRole('administrador') && !auth()->user()->hasRole('jefa')) {
            $role = Role::find($validated['role_id']);
            if (!in_array($role->slug, ['empleado', 'cliente'])) {
                return redirect()->back()
                    ->with('error', 'No tienes permiso para crear usuarios con este rol')
                    ->withInput();
            }
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        $user = User::create($validated);

        // Asignar rol al usuario
        $user->roles()->attach($validated['role_id']);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    public function show(User $user)
    {
        $user->load('roles');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Si es Admin, verificar que solo edite Empleado o Cliente
        if (auth()->user()->hasRole('administrador') && !auth()->user()->hasRole('jefa')) {
            $userRole = $user->roles->first();
            if ($userRole && !in_array($userRole->slug, ['empleado', 'cliente'])) {
                return redirect()->route('users.index')
                    ->with('error', 'No tienes permiso para editar este usuario');
            }
        }

        $query = Role::where('is_active', true);

        // Si es Admin, solo mostrar roles Empleado y Cliente
        if (auth()->user()->hasRole('administrador') && !auth()->user()->hasRole('jefa')) {
            $query->whereIn('slug', ['empleado', 'cliente']);
        }

        $roles = $query->get();
        $user->load('roles');
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Si es Admin, verificar que solo actualice Empleado o Cliente
        if (auth()->user()->hasRole('administrador') && !auth()->user()->hasRole('jefa')) {
            $userRole = $user->roles->first();
            if ($userRole && !in_array($userRole->slug, ['empleado', 'cliente'])) {
                return redirect()->route('users.index')
                    ->with('error', 'No tienes permiso para editar este usuario');
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'boolean',
        ]);

        // Si es Admin, verificar que el nuevo rol sea Empleado o Cliente
        if (auth()->user()->hasRole('administrador') && !auth()->user()->hasRole('jefa')) {
            $role = Role::find($validated['role_id']);
            if (!in_array($role->slug, ['empleado', 'cliente'])) {
                return redirect()->back()
                    ->with('error', 'No tienes permiso para asignar este rol')
                    ->withInput();
            }
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        // Actualizar rol del usuario
        $user->roles()->sync([$validated['role_id']]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        // Proteger: No se puede eliminar a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminarte a ti mismo');
        }

        // Si es Admin, verificar que solo elimine Empleado o Cliente
        if (auth()->user()->hasRole('administrador') && !auth()->user()->hasRole('jefa')) {
            $userRole = $user->roles->first();
            if ($userRole && !in_array($userRole->slug, ['empleado', 'cliente'])) {
                return redirect()->route('users.index')
                    ->with('error', 'No tienes permiso para eliminar este usuario');
            }
        }

        // La Jefa puede eliminar Admin, Empleado y Cliente
        // El Admin puede eliminar Empleado y Cliente
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}
