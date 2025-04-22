<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Publicacion;
use App\Models\Evento;
use App\Models\Categoria;


class Welcome extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        $eventos = Evento::all();
        $categorias = Categoria::all(); // Obtener todas las categorías
        $categoriasSugeridas = Categoria::inRandomOrder()->limit(5)->get(); // 5 aleatorias


        $publicaciones = Publicacion::with(['fotos', 'videos', 'categorias', 'comentarios'])
            ->where('status', 1)
            ->orderBy('fecha_publicacion', 'desc') // Ordenar por fecha de publicación (más recientes primero)
            ->get();

        $nopublicaciones = Publicacion::with(['fotos', 'videos', 'categorias', 'comentarios'])
            ->where('status', 0)
            ->orderBy('fecha_publicacion', 'desc') // Aplicar el mismo orden
            ->get();

        return view('welcome', compact('user', 'publicaciones', 'nopublicaciones', 'eventos', 'categorias', 'categoriasSugeridas'));
    }

    public function toggleLike($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 403);
        }

        $like = Like::where('user_id', $user->id)->where('publicacion_id', $id)->first();

        if ($like) {
            // Si ya existe el like, lo eliminamos
            $like->delete();
            $publicacion->decrement('likes');
            $liked = false;
        } else {
            // Si no existe, lo creamos
            Like::create([
                'user_id' => $user->id,
                'publicacion_id' => $id,
            ]);
            $publicacion->increment('likes');
            $liked = true;
        }

        return response()->json(['likes' => $publicacion->likes, 'liked' => $liked]);
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
