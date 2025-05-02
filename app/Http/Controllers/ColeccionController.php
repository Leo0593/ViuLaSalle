<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coleccion;
use App\Models\PublicacionColeccion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class ColeccionController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'ADMIN') {
            // ADMIN puede ver todas las colecciones sin restricciones
            $colecciones = Coleccion::with('creador', 'usuarios')->get();

        } elseif ($user->role == 'PROFESOR') {
            // PROFESOR solo puede ver colecciones activas que ha creado o en las que ha sido agregado
            $colecciones = Coleccion::with('creador', 'usuarios')
                ->where('status', 1)
                ->where(function ($query) use ($user) {
                    $query->where('creador_id', $user->id)
                        ->orWhereHas('usuarios', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        });
                })
                ->get();

        } else {
            // USER solo puede ver colecciones activas donde ha sido agregado
            $colecciones = Coleccion::with('creador', 'usuarios')
                ->where('status', 1)
                ->whereHas('usuarios', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();
        }

        return view('coleccion.index', compact('colecciones'));
    }


    public function create()
    {
        $users = User::all(); // Obtener todos los usuarios
        return view('coleccion.create', compact('users')); // Pasar los usuarios a la vista
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'usuarios' => 'nullable|array', // Los usuarios seleccionados
            'usuarios.*' => 'exists:users,id', // Validar que cada ID de usuario sea válido
        ]);

        // Crear la colección
        $coleccion = Coleccion::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'creador_id' => Auth::id(), // ID del usuario logueado
            'status' => 1, // Colección activa
        ]);

        // Asociar los usuarios seleccionados a la colección
        if ($request->has('usuarios')) {
            $coleccion->usuarios()->sync($request->usuarios); // Sincroniza la relación muchos a muchos
        }

        // Redirigir a la vista de colecciones con mensaje de éxito
        return redirect()->route('colecciones.index')->with('success', 'Colección creada exitosamente.');
    }

    public function edit(string $id)
    {
        $coleccion = Coleccion::findOrFail($id);
        $users = User::all(); // Obtener todos los usuarios
        return view('coleccion.edit', compact('coleccion', 'users')); // Pasar la colección y los usuarios a la vista
    }

    public function update(Request $request, string $id)
    {
        // Buscar la colección por su ID
        $coleccion = Coleccion::findOrFail($id);

        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'usuarios' => 'nullable|array', // Los usuarios seleccionados
            'usuarios.*' => 'exists:users,id', // Validar que cada ID de usuario sea válido
        ]);

        // Actualizar los datos de la colección
        $coleccion->nombre = $request->nombre;
        $coleccion->descripcion = $request->descripcion;
        $coleccion->save(); // Guardar los cambios en la colección

        // Asociar los usuarios seleccionados a la colección
        if ($request->has('usuarios')) {
            $coleccion->usuarios()->sync($request->usuarios); // Sincronizar los usuarios
        }

        // Redirigir a la vista de colecciones con un mensaje de éxito
        return redirect()->route('colecciones.index')->with('success', 'Colección actualizada exitosamente.');
    }

    public function destroy(string $id)
    {
        $coleccion = Coleccion::findOrFail($id);
        $coleccion->update(['status' => 0]);
        return redirect()->route('colecciones.index')->with('success', 'Publicación desactivada correctamente.');
    }

    public function activate(string $id)
    {
        $coleccion = Coleccion::findOrFail($id);
        $coleccion->update(['status' => 1]);
        return redirect()->route('colecciones.index')->with('success', 'Publicación activada correctamente.');
    }

    public function show($id)
    {
        $user = auth()->user();  

        if ($user->role == 'ADMIN') {
            $publicaciones = PublicacionColeccion::with('usuario', 'fotos')
                ->where('coleccion_id', $id)
                ->get();
        } else {
            $publicaciones = PublicacionColeccion::with('usuario', 'fotos')
                ->where('coleccion_id', $id)
                ->where('status', 1)  
                ->get();
        }

        $coleccion = Coleccion::with('creador', 'usuarios')->findOrFail($id);

        return view('coleccion.show', compact('coleccion', 'publicaciones'));
    }


}
