<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirigir según el rol del usuario
        $user = Auth::user();

        if ($user->isCliente()) {
            // Clientes van al catálogo de productos
            return redirect()->intended(route('client.dashboard'));
        } elseif ($user->isJefa()) {
            // Jefa va a su dashboard ejecutivo
            return redirect()->intended(route('jefa.dashboard'));
        } elseif ($user->isAdmin()) {
            // Administradores van a su dashboard específico
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->isEmpleado()) {
            // Empleados van al panel de pedidos
            return redirect()->intended(route('orders.index'));
        }

        // Fallback al home por defecto
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
