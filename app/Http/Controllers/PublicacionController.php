<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use App\Models\User;
use App\Models\Evento;
use Carbon\Carbon; // Para obtener la fecha actual
use App\Models\FotoPublicacion;

class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publicaciones = Publicacion::with('fotos')->get();
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
        // Validar los datos del formulario
        $request->validate([
            'id_user' => 'required|exists:users,id',       // Verifica que el usuario exista
            'id_evento' => 'required|exists:eventos,id',   // Verifica que el evento exista
            'descripcion' => 'required|string|max:255',    // Descripción es obligatoria y tiene un límite de caracteres
            'fotos' => 'nullable|array',                    // Aceptar un array de fotos
            'fotos.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación para las fotos
        ]);

        // Crear la publicación
        $publicacion = Publicacion::create([
            'id_user' => $request->id_user,
            'id_evento' => $request->id_evento,
            'descripcion' => $request->descripcion,
            'fecha_publicacion' => Carbon::now(), // Fecha actual
            'status' => 1, // Estado por defecto es 1
        ]);

        // Subir las fotos
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                // Guardar cada foto en el directorio 'public/publicaciones' y obtener la ruta
                $rutaFoto = $foto->store('publicaciones','public');  // Aquí se cambia el nombre del directorio a 'publicaciones'

                // Crear una nueva entrada en la tabla de fotos asociada a la publicación
                FotoPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'ruta_foto' => basename($rutaFoto), // Guardamos solo el nombre del archivo
                ]);
            }
        }

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
