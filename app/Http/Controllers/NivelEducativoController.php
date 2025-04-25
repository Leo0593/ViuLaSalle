<?php

namespace App\Http\Controllers;

use App\Models\NivelEducativo;
use Illuminate\Http\Request;

class NivelEducativoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role == 'ADMIN') {
            $niveles = NivelEducativo::all();
        } else {
            $niveles = NivelEducativo::where('status', 1)->get();
        }
        return view('niveles.index', compact('niveles', 'user'));
    }


    public function create()
    {
        return view('niveles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        NivelEducativo::create([
            'nombre' => $request->nombre,
            'status' => 1,
        ]);

        return redirect()->route('niveles.index')->with('success', 'Nivel educativo creado correctamente.');
    }

    public function edit($id)
    {
        $nivel = NivelEducativo::findOrFail($id);
        return view('niveles.edit', compact('nivel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $nivel = NivelEducativo::findOrFail($id);
        $nivel->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('niveles.index')->with('success', 'Nivel educativo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $nivel = NivelEducativo::findOrFail($id);
        $nivel->update(['status' => 0]);
        return redirect()->route('niveles.index')->with('success', 'Nivel educativo desactivado correctamente.');
    }

    public function activate($id)
    {
        $nivel = NivelEducativo::findOrFail($id);
        $nivel->update(['status' => 1]);
        return redirect()->route('niveles.index')->with('success', 'Nivel educativo activado correctamente.');
    }


    public function show()
    {
        return view('niveles.show');
    }
}
