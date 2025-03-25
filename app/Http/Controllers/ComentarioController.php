<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Publicacion;


use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{

    public function verComentarios($id_publicacion)
    {
        // Obtener la publicación con los comentarios que tengan status 1
        $publicacion = Publicacion::with(['comentarios' => function($query) {
            $query->where('status', 1); // Filtrar solo los comentarios con status 1
        }, 'comentarios.usuario'])->findOrFail($id_publicacion);
    
        return view('comentarios.index', compact('publicacion'));
    }

 

    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string|max:500',
            'id_publicacion' => 'required|exists:publicaciones,id',
        ]);

        Comentario::create([
            'id_user' => Auth::id(), // Obtiene el usuario logueado
            'id_publicacion' => $request->id_publicacion,
            'contenido' => $request->contenido,
            'status' => '1', 
        ]);

        return redirect()->back()->with('success', 'Comentario agregado correctamente.');
    }

    public function changeStatus($id)
    {
        $comentario = Comentario::findOrFail($id);

        // Cambiar el status de 1 a 0 o de 0 a 1
        $comentario->status = ($comentario->status == 1) ? 0 : 1;

        $comentario->save();

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Estado del comentario actualizado correctamente.');
    }
}
