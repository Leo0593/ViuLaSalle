<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; // Asegúrate de incluir el modelo User

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
        // Autenticamos al usuario
        $request->authenticate();

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar si el campo 'status' del usuario es 0
        if ($user->status == 0) {
            // Si el valor de 'status' es 0, cerramos la sesión y redirigimos a la página de login con un mensaje
            Auth::logout();
            return redirect()->route('login')->withErrors(['account_inactive' => 'Tu cuenta está inactiva.']);
        }

        // Regenerar la sesión
        $request->session()->regenerate();

        // Redirigir al usuario a la página deseada
        return redirect()->intended(route('dashboard', absolute: false));
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
