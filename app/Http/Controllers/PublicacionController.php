<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use App\Models\FotoPublicacion;
use App\Models\User;
use App\Models\Evento;


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
        // Obtener usuarios y eventos para llenar los selectores
        $usuarios = User::all();
        $eventos = Evento::all();

        return view('publicaciones.create', compact('usuarios', 'eventos'));
    }

    /**
     * Almacenar una nueva publicación en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_evento' => 'required|exists:eventos,id',
            'descripcion' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Crear la publicación
        $publicacion = Publicacion::create([
            'id_user' => $validated['id_user'],
            'id_evento' => $validated['id_evento'],
            'descripcion' => $validated['descripcion'],
            'fecha_publicacion' => $validated['fecha_publicacion'],
            'visible' => true, // Puedes agregar la lógica para la visibilidad
        ]);

        // Subir las fotos si existen
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('public/fotos'); // Guarda en storage/app/public/fotos
                FotoPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'ruta_foto' => basename($path), // Solo guardamos el nombre del archivo
                ]);
            }
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('publicaciones.index')->with('success', 'Publicación creada exitosamente!');
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
