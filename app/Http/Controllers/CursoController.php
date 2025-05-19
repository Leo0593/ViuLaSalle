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

    public function create()
    {
        $niveles = NivelEducativo::all();
        return view('cursos.create', compact('niveles'));
    }

    public function store(Request $request)
    {
        // Validar datos y archivo PDF
        $validated = $request->validate([
            'id_nivel' => 'required|exists:nivel_educativo,id',
            'nombre' => 'required|string|max:255',
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'video' => 'nullable|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf|max:10000',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Si llega la imagen, subir y guardar la ruta
        $imgPath = null;
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('imagenes_cursos', 'public');
        }

        // Crear el curso
        $curso = Curso::create([
            'id_nivel' => $request->id_nivel,
            'nombre' => $request->nombre,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'video' => $request->video,
            'img' => $imgPath,
            
            'status' => 1,
        ]);

        return redirect()->route('cursos.index')->with('success', 'Curso creado correctamente.');
    }



    /*
    public function store(Request $request)
    {
        $request->validate([
            'id_nivel' => 'required|exists:nivel_educativo,id',
            'nombre' => 'required|string|max:255',
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'img' => 'nullable|string|max:255',
            'video' => 'nullable|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf|max:10000',
        ]); 

     
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('imagenes_cursos', 'public');
        } else {
            $imgPath = null;
        }

        
        $pdfPath = null;
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('pdf_cursos', 'public');
        }

        // Crear el curso
        $curso = Curso::create([
            'id_nivel' => $request->id_nivel,
            'nombre' => $request->nombre,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'img' => $request->img,
            'video' => $request->video,
            'pdf' => $pdfPath,
            'status' => 1,
        ]);

        return redirect()->route('cursos.index')->with('success', 'Curso creado correctamente.');
    }
    */

    public function edit(string $id)
    {
        $curso = Curso::with('fotos')->findOrFail($id);
        $niveles = NivelEducativo::all();

        return view('cursos.edit', compact('curso', 'niveles'));
    }

    public function update(Request $request, string $id)
    {
        $curso = Curso::findOrFail($id);

        try {
            $validated = $request->validate([
                'id_nivel' => 'required|exists:nivel_educativo,id',
                'nombre' => 'required|string|max:255',
                'titulo' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'pdf' => 'nullable|file|mimes:pdf|max:10000',
                'video' => 'nullable|string|max:255',
                'delete_pdf' => 'nullable|boolean',
            ]);
        } catch (\Exception $e) {
            dd('Error en validación: ', $e->getMessage());
        }

        /*
        $request->validate([
            'id_nivel' => 'required|exists:nivel_educativo,id',
            'nombre' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf' => 'nullable|file|mimes:pdf|max:10000',
            'video' => 'nullable|string|max:255',
            'delete_pdf' => 'nullable|boolean',
        ]); */

        // Subir nueva imagen si se cargó
        if ($request->hasFile('img')) {
            if ($curso->img) {
                Storage::disk('public')->delete($curso->img);
            }
            $imgPath = $request->file('img')->store('imagenes_cursos', 'public');
            $curso->img = $imgPath;
        }

        // Eliminar PDF existente si se solicitó
        if ($request->boolean('delete_pdf') && $curso->pdf) {
            Storage::disk('public')->delete($curso->pdf);
            $curso->pdf = null;
        }

        // Subir nuevo PDF si se cargó
        if ($request->hasFile('pdf')) {
            if ($curso->pdf) {
                Storage::disk('public')->delete($curso->pdf);
            }
            $pdfPath = $request->file('pdf')->store('pdf_cursos', 'public');
            $curso->pdf = $pdfPath;
        }

        // Actualizar campos
        $curso->id_nivel = $request->id_nivel;
        $curso->nombre = $request->nombre;
        $curso->titulo = $request->titulo;
        $curso->descripcion = $request->descripcion;
        $curso->video = $request->video;
        $curso->save();

        //return redirect()->route('cursos.index')->with('success', 'Curso actualizado correctamente.');
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
