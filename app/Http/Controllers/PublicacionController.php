<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use App\Models\User;
use App\Models\Evento;
use Carbon\Carbon; // Para obtener la fecha actual


class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publicaciones = Publicacion::all();
        return view('publicaciones.index', compact('publicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los usuarios y eventos disponibles
        $usuarios = User::all();
        $eventos = Evento::all();

        // Retornar la vista con los datos
        return view('publicaciones.create', compact('usuarios', 'eventos'));
    }

    /**
     * Almacenar una nueva publicación en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario (eliminamos 'status' de la validación)
        $request->validate([
            'id_user' => 'required|exists:users,id',       // Verifica que el usuario exista
            'id_evento' => 'required|exists:eventos,id',   // Verifica que el evento exista
            'descripcion' => 'required|string|max:255',    // Descripción es obligatoria y tiene un límite de caracteres
        ]);

        // Crear la publicación
        Publicacion::create([
            'id_user' => $request->id_user,
            'id_evento' => $request->id_evento,
            'descripcion' => $request->descripcion,
            'fecha_publicacion' => Carbon::now(), // Fecha actual
            'status' => 1, // Estado por defecto es 1
        ]);

        // Redirigir a la lista de publicaciones con un mensaje de éxito
        return redirect()->route('publicaciones.index')->with('success', 'Publicación creada correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
