<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Publicacion;
use App\Models\Evento;
use App\Models\Categoria;
use App\Models\Notificacion;
use App\Models\NivelEducativo;
use App\Models\Curso;

class Welcome extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $eventos = Evento::where('status', 1)->get();
        $categorias = Categoria::where('status', 1)->get(); // Solo categorías con status = 1
        $categoriasSugeridas = Categoria::where('status', 1)->inRandomOrder()->limit(5)->get(); // 5 aleatorias con status = 1

        $niveles = NivelEducativo::where('status', 1)->get();
        $cursos = Curso::with('nivelEducativo', 'fotos')
            ->where('status', 1)
            ->get();

        $publicaciones = Publicacion::with(['fotos', 'videos', 'categorias', 'comentarios'])
            ->where('status', 1)
            ->orderBy('fecha_publicacion', 'desc') // Ordenar por fecha de publicación (más recientes primero)
            ->get();

        $nopublicaciones = Publicacion::with(['fotos', 'videos', 'categorias', 'comentarios'])
            ->where('status', 0)
            ->orderBy('fecha_publicacion', 'desc') // Aplicar el mismo orden
            ->get();

        $notificaciones = Notificacion::with('creador')
            ->where('es_global', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('welcome', compact(
            'user', 
            'publicaciones', 
            'nopublicaciones', 
            'eventos', 
            'categorias', 
            'categoriasSugeridas', 
            'notificaciones', 
            'niveles', 
            'cursos'
        ));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
