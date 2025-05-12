<?php

namespace App\Http\Controllers;

use App\Models\NivelEducativo;
use Illuminate\Http\Request;

use Carbon\Carbon; // Para obtener la fecha actual
use App\Models\FotoPublicacion;
use App\Models\VideoPublicacion;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Publicacion;


class NivelEducativoController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Puede ser null si no está logueado

        if ($user && $user->role == 'ADMIN') {
            $niveles = NivelEducativo::all(); // Admin ve todos
        } else {
            $niveles = NivelEducativo::where('status', 1)->get(); // Otros ven solo activos
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
        $publicaciones = Publicacion::with('fotos', 'videos')->get(); // Carga todas las publicaciones con sus fotos y videos

        return view('niveles.show', compact('publicaciones'));
    }
}
