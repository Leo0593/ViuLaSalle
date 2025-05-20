<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenido;

class ContenidoController extends Controller
{
    public function index()
    {
        $contenidos = Contenido::all(); // Obtener todos los contenidos

        return view('contenido.index', compact('contenidos'));
    }

    public function create()
    {
        return view('contenido.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_vista' => 'required|integer',
            'vista_tipo' => 'required|in:curso,evento',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'video' => 'nullable|string|max:255',
            'opcion' => 'required|integer',
        ]);

        $contenido = new Contenido();

        $contenido->id_vista = $request->id_vista;
        $contenido->vista_tipo = $request->vista_tipo;
        $contenido->tipo = $request->tipo;
        $contenido->titulo = $request->titulo;
        $contenido->descripcion = $request->descripcion;
        $contenido->video = $request->video;
        $contenido->opcion = $request->opcion;

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('imagenes', 'public');
            $contenido->imagen = $imagenPath;
        }

        $contenido->save();

        return redirect()->route('contenido.index')->with('success', 'Contenido creado correctamente.');
    }

    public function edit(string $id)
    {
        $contenido = Contenido::findOrFail($id);
        return view('contenido.edit', compact('contenido'));
    }

    public function update(Request $request, string $id)
    {
        $contenido = Contenido::findOrFail($id);

        $request->validate([
            'id_vista' => 'required|integer',
            'vista_tipo' => 'required|in:curso,evento',
            'tipo' => 'nullable|string|max:50',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'video' => 'nullable|string|max:255',
            'opcion' => 'required|integer',
        ]);

        $contenido->id_vista = $request->id_vista;
        $contenido->vista_tipo = $request->vista_tipo;
        $contenido->tipo = $request->tipo;
        $contenido->titulo = $request->titulo;
        $contenido->descripcion = $request->descripcion;
        $contenido->video = $request->video;
        $contenido->opcion = $request->opcion;

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('imagenes', 'public');
            $contenido->imagen = $imagenPath;
        }

        $contenido->save();

        return redirect()->route('contenido.index')->with('success', 'Contenido actualizado correctamente.');
    }


    public function show(string $id)
    {
        $contenido = Contenido::findOrFail($id);
        return view('contenido.show', compact('contenido'));
    }

    public function destroy(string $id)
    {
        //
    }
}
