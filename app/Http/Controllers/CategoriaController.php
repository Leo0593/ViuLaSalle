<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Categoria::query();

        // Si el usuario NO es ADMIN, solo mostrar las activas
        if ($user->role != 'ADMIN') {
            $query->where('status', 1);
        }

        // Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtro por estado (solo si es ADMIN, los demás ya tienen filtro por 'activo')
        if ($user->role == 'ADMIN' && $request->filled('status')) {
            $query->where('status', $request->status);
        }

        $categorias = $query->get();

        return view('categorias.index', compact('categorias', 'user'));
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
        //return view('categorias.edit', compact('categoria'));
        return response()->json($categoria);

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
        $categoria->status = 0; // Desactivar
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoría desactivada correctamente.');
    }

    public function activate($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->status = 1; // Activar
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoría activada correctamente.');
    }

}