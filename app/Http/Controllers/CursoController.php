<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\NivelEducativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FotoCurso;



class CursoController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Curso::with('nivelEducativo', 'fotos');

        // Filtramos por estado solo para usuarios no ADMIN
        if ($user && $user->role !== 'ADMIN') {
            $query->where('status', 1);  // Solo activos para usuarios que no sean admin
        }

        // Si viene el filtro por nivel
        if ($request->filled('nivel')) {
            $nivel = strtolower($request->nivel);
            $query->whereHas('nivelEducativo', function ($q) use ($nivel) {
                $q->whereRaw('LOWER(nombre) = ?', [$nivel]);
            });
        }

        $cursos = $query->get();

        return view('cursos.index', compact('cursos', 'user'));
    }

    /*public function index()
    {
        $user = auth()->user();

        if ($user->role === 'ADMIN') {
            $cursos = Curso::with('nivelEducativo', 'fotos')->get();
        } else {
            $cursos = Curso::with('nivelEducativo', 'fotos')->where('status', 1)->get();
        }

        return view('cursos.index', compact('cursos', 'user'));
    }*/

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
            'duracion' => 'nullable|string|max:100',
            'posibilidades_continuidad' => 'nullable|string',
            'sector_profesional' => 'nullable|string|max:255',
            'salidas_profesionales' => 'nullable|string',
            'asignaturas_pdf' => 'nullable|mimes:pdf|max:2048',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Subida del PDF (si se envió)
        $pdfPath = null;
        if ($request->hasFile('asignaturas_pdf')) {
            $pdfPath = $request->file('asignaturas_pdf')->store('asignaturas_pdfs', 'public');
        }

        // Crear el curso
        $curso = Curso::create([
            'id_nivel' => $request->id_nivel,
            'nombre' => $request->nombre,
            'duracion' => $request->duracion,
            'posibilidades_continuidad' => $request->posibilidades_continuidad,
            'sector_profesional' => $request->sector_profesional,
            'salidas_profesionales' => $request->salidas_profesionales,
            'asignaturas_pdf' => $pdfPath,
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
            'duracion' => 'nullable|string|max:100',
            'posibilidades_continuidad' => 'nullable|string',
            'sector_profesional' => 'nullable|string|max:255',
            'salidas_profesionales' => 'nullable|string',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_fotos' => 'nullable|array',
            'asignaturas_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'delete_pdf' => 'nullable|boolean',
        ]);

        // Actualizar curso
        $curso->update([
            'id_nivel' => $request->id_nivel,
            'nombre' => $request->nombre,
            'duracion' => $request->duracion,
            'posibilidades_continuidad' => $request->posibilidades_continuidad,
            'sector_profesional' => $request->sector_profesional,
            'salidas_profesionales' => $request->salidas_profesionales,
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

        // Eliminar PDF existente si se marcó
        if ($request->has('delete_pdf') && $curso->asignaturas_pdf) {
            Storage::disk('public')->delete($curso->asignaturas_pdf);
            $curso->asignaturas_pdf = null;
            $curso->save();
        }

        // Subir nuevo PDF
        if ($request->hasFile('asignaturas_pdf')) {
            // Borrar anterior si existe
            if ($curso->asignaturas_pdf) {
                Storage::disk('public')->delete($curso->asignaturas_pdf);
            }

            $pdfPath = $request->file('asignaturas_pdf')->store('pdf_asignaturas', 'public');
            $curso->asignaturas_pdf = $pdfPath;
            $curso->save();
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

    public function show(string $id)
    {
        $curso = Curso::with('nivelEducativo', 'fotos')->findOrFail($id);
        return view('cursos.show', compact('curso'));
    }


}
