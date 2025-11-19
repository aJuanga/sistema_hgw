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
            // Clientes van a la página "Acerca de HGW"
            return redirect()->intended(route('client.about'));
        } elseif ($user->isEmpleado()) {
            // Empleados van a su dashboard específico
            return redirect()->intended(route('employee.dashboard'));
        } elseif ($user->hasAnyRole(['jefa', 'administrador'])) {
            // Jefa y Administrador van al dashboard general
            return redirect()->intended(route('dashboard'));
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
