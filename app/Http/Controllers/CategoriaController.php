<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::where('status', 1)->get();
        return view('categorias.index', compact('categorias')); 
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $user_id = auth()->id();

        $categoria = new Categoria();
        $categoria->nombre = $validated['nombre'];
        $categoria->status = true;
        $categoria->id_user = $user_id;
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoria creada correctamente.');
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $validated['nombre'];
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoria actualizada correctamente.');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->status = 0;
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoria eliminada correctamente.');
    }
}