<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; // Asegúrate de incluir el modelo User

use Illuminate\Support\Str;
use App\Notifications\TwoFactorEnabledNotification;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if ($user->status == 0) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['account_inactive' => 'Tu cuenta está inactiva.']);
        }

        $request->session()->regenerate();

        // ✅ Generar código aleatorio de 10 caracteres
        $codigo = Str::upper(Str::random(10)); // letras y números, en mayúscula

        // ✅ Guardar en sesión
        session(['codigo_2fa' => $codigo]);

        // ✅ Enviar notificación por correo
        $user->notify(new TwoFactorEnabledNotification($codigo));

        return redirect()->route('verificacion.index');
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
