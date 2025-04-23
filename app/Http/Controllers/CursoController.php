<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\NivelEducativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FotoCurso;


class CursoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'ADMIN') {
            $cursos = Curso::with('nivelEducativo', 'fotos')->get();
        } else {
            $cursos = Curso::with('nivelEducativo', 'fotos')->where('status', 1)->get();
        }

        return view('cursos.index', compact('cursos', 'user'));
    }

    public function create()
    {
        $niveles = NivelEducativo::all();
        return view('cursos.create', compact('niveles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_nivel' => 'required|exists:nivel_educativo,id',
            'nombre' => 'required|string|max:255',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Crear el curso
        $curso = Curso::create([
            'id_nivel' => $request->id_nivel,
            'nombre' => $request->nombre,
            'status' => 1,
        ]);

        // Subir y guardar las fotos (si se enviaron)
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('fotos_cursos', 'public');

                FotoCurso::create([
                    'curso_id' => $curso->id,
                    'ruta_imagen' => $path,
                ]);
            }
        }

        return redirect()->route('cursos.index')->with('success', 'Publicación creada correctamente.');

    }
    
    public function edit(string $id)
    {
        $curso = Curso::with('fotos')->findOrFail($id);
        $niveles = NivelEducativo::all();

        return view('cursos.edit', compact('curso', 'niveles'));
    }

    public function update(Request $request, string $id)
    {
        $curso = Curso::findOrFail($id);

        $request->validate([
            'id_nivel' => 'required|exists:nivel_educativo,id',
            'nombre' => 'required|string|max:255',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_fotos' => 'nullable|array',
        ]);

        // Actualizar curso
        $curso->update([
            'id_nivel' => $request->id_nivel,
            'nombre' => $request->nombre,
        ]);

        // Eliminar fotos seleccionadas
        if ($request->has('delete_fotos')) {
            foreach ($request->delete_fotos as $fotoId) {
                $foto = FotoCurso::find($fotoId);
                if ($foto) {
                    Storage::disk('public')->delete($foto->ruta_imagen);
                    $foto->delete();
                }
            }
        }

        // Agregar nuevas fotos
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('fotos_cursos', 'public');
                FotoCurso::create([
                    'curso_id' => $curso->id,
                    'ruta_imagen' => $path,
                ]);
            }
        }

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado correctamente.');
    }


    public function destroy(string $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->update(['status' => 0]);

        return redirect()->route('cursos.index')->with('success', 'Curso desactivado correctamente.');
    }

    public function activate(string $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->update(['status' => 1]);

        return redirect()->route('cursos.index')->with('success', 'Curso activado correctamente.');
    }


}
