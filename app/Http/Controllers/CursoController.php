<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\NivelEducativo;
use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use App\Models\FotoCurso;
use App\Models\Contenido;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Curso::with('nivelEducativo', 'fotos');

        // Filtrar por estado si el usuario no es ADMIN
        if ($user && $user->role !== 'ADMIN') {
            $query->where('status', 1);  // Solo activos para no admins
        }

        // Filtro por nombre
        if ($request->filled('nombre')) {
            $nombre = strtolower($request->nombre);
            $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . $nombre . '%']);
        }

        // Filtro por estado (solo aplica si es admin)
        if ($user && $user->role === 'ADMIN' && $request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por nivel educativo
        if ($request->filled('nivel')) {
            $nivel = strtolower($request->nivel);
            $query->whereHas('nivelEducativo', function ($q) use ($nivel) {
                $q->whereRaw('LOWER(nombre) = ?', [$nivel]);
            });
        }

        // Filtro por rango de fechas (basado en fecha de creación)
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Paginación
        $cursos = $query->paginate(5)->withQueryString(); // para mantener los filtros en los links

        return view('cursos.index', compact('cursos', 'user'));
    }


    public function create()
    {
        $niveles = NivelEducativo::all();
        return view('cursos.create', compact('niveles'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'id_nivel' => 'required|exists:nivel_educativo,id',
            'nombre' => 'required|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf|max:10000',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Guardar PDF si fue subido
        if ($request->hasFile('pdf')) {
            $validated['pdf'] = $request->file('pdf')->store('pdfs', 'public');
        }

        // Guardar imagen si fue subida
        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('imagenes', 'public');
        }

        // Crear el curso
        $curso = Curso::create($validated);

        // Crear una categoría con el mismo nombre del curso
        Categoria::create([
            'nombre' => $curso->nombre,
            'status' => 1,
            'id_user' => auth()->id(),
        ]);


        // Redirigir con mensaje de éxito
        return redirect()->route('cursos.index')->with('success', 'Curso creado correctamente.');
    }

    public function edit(string $id)
    {
        $niveles = NivelEducativo::all();

        $curso = Curso::with(['nivelEducativo', 'fotos'])->findOrFail($id);

        $contenidos = $curso->contenido()
            ->where('vista_tipo', 'curso')
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->get();


        return view('cursos.edit', compact('curso', 'niveles', 'contenidos'));
    }

    public function update(Request $request, string $id)
    {
        // Validación
        $validated = $request->validate([
            'id_nivel' => 'required|exists:nivel_educativo,id',
            'nombre' => 'required|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf|max:10000',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Buscar y actualizar curso
        $curso = Curso::findOrFail($id);

        // Guardar nuevo PDF si fue subido
        if ($request->hasFile('pdf')) {
            $validated['pdf'] = $request->file('pdf')->store('pdfs', 'public');
        }

        // Guardar nueva imagen si fue subida
        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('imagenes', 'public');
        }

        $curso->update($validated);

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
        $curso = Curso::with(['nivelEducativo', 'fotos'])->findOrFail($id);

        $contenidos = $curso->contenido()
            ->where('vista_tipo', 'curso')
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('cursos.show', compact('curso', 'contenidos'));
    }
}
