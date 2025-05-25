<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenido;
use App\Models\Curso; // Asegúrate de importar el modelo Curso
use App\Models\Evento;

class ContenidoController extends Controller
{
    public function index()
    {
        $contenidos = Contenido::all(); // Obtener todos los contenidos

        return view('contenido.index', compact('contenidos'));
    }

    public function create(string $tipo, string $vista)
    {
        if ($tipo === 'curso') {
            $modelo = Curso::findOrFail($vista);
        } elseif ($vista_tipo === 'evento') {
            $modelo = Evento::findOrFail($vista);
        } else {
            abort(404, 'Vista tipo no válida');
        }

        return view('contenido.create', compact('modelo', 'tipo'));
    }

    public function store(Request $request, string $tipo, string $vista)
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

        return redirect()->route(
            $tipo === 'evento' ? 'eventos.edit' : 'cursos.edit',
            ['id' => $vista]
        )->with('success', 'Contenido creado correctamente.');
    }

    public function edit(string $tipo, string $vista_id, string $contenido_id)
    {
        $contenido = Contenido::findOrFail($contenido_id);

        if ($tipo === 'curso') {
            $modelo = Curso::findOrFail($vista_id);
        } elseif ($tipo === 'evento') {
            $modelo = Evento::findOrFail($vista_id);
        } else {
            abort(404, 'Tipo de vista no válido');
        }

        return view('contenido.edit', compact('contenido', 'modelo', 'tipo'));
    }

    public function update(Request $request, string $tipo, string $vista_id, string $contenido_id)
    {
        $contenido = Contenido::findOrFail($contenido_id);

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

        return redirect()->route(
            $tipo === 'evento' ? 'eventos.edit' : 'cursos.edit',
            ['id' => $vista_id]
        )->with('success', 'Contenido actualizado correctamente.');
    }

    public function show(string $id)
    {
        $contenido = Contenido::findOrFail($id);
        return view('contenido.show', compact('contenido'));
    }

    public function destroy(string $tipo, string $vista_id, string $contenido_id)
    {
        $contenido = Contenido::findOrFail($contenido_id);
        $contenido->update(['status' => 0]);

        return redirect()->route(
            $tipo === 'evento' ? 'eventos.edit' : 'cursos.edit',
            ['id' => $vista_id]
        )->with('success', 'Contenido eliminado correctamente.');
    }

    public function activate(string $tipo, string $vista_id, string $contenido_id)
    {
        $contenido = Contenido::findOrFail($contenido_id);
        $contenido->update(['status' => 1]);

        return redirect()->route(
            $tipo === 'evento' ? 'eventos.edit' : 'cursos.edit',
            ['id' => $vista_id]
        )->with('success', 'Contenido activado correctamente.');
    }
}
