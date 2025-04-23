<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class VerificacionController extends Controller
{

    public function index()
    {
        return view('auth.verificacion-doble'); // Asegúrate de crear esta vista
    }

    public function validar(Request $request)
    {
        $codigoIngresado = $request->input('codigo');
        $codigoCorrecto = session('codigo_2fa');

        if ($codigoIngresado === $codigoCorrecto) {
            // Eliminar código de la sesión para no reutilizarlo
            session()->forget('codigo_2fa');
            return redirect()->route('welcome');
        }

        return redirect()->route('verificacion.index')->with('error', 'Código incorrecto. Intenta de nuevo.');
    }

}
