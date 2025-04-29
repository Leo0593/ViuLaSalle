<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\NotificacionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    // Mostrar listado de notificaciones
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'ADMIN') {
            // Admin ve todas las notificaciones, sin importar estado
            $notificaciones = Notificacion::with('creador')->latest()->get();
        } elseif ($user->role === 'PROFESOR') {
            // Profesor ve globales, las suyas, y las que le mandaron, solo si están activas
            $notificaciones = Notificacion::with('creador')
                ->where('status', 1)
                ->where(function ($query) use ($user) {
                    $query->where('es_global', true)
                        ->orWhere('creador_id', $user->id)
                        ->orWhereHas('destinatarios', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        });
                })
                ->latest()
                ->get();
        } else {
            // USER ve globales y las que le enviaron, solo si están activas
            $notificaciones = Notificacion::with('creador')
                ->where('status', 1)
                ->where(function ($query) use ($user) {
                    $query->where('es_global', true)
                        ->orWhereHas('destinatarios', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        });
                })
                ->latest()
                ->get();
        }

        return view('notificaciones.index', compact('notificaciones'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $usuarios = User::all(); // para seleccionar destinatarios si es necesario
        return view('notificaciones.create', compact('usuarios'));
    }

    // Guardar nueva notificación
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'es_global' => 'required|boolean',
            'usuarios' => 'nullable|array',
        ]);

        $notificacion = Notificacion::create([
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'es_global' => $request->es_global,
            'creador_id' => Auth::id(),
            'status' => 1,
        ]);

        if (!$request->es_global && $request->has('usuarios')) {
            $notificacion->destinatarios()->attach($request->usuarios);
        }

        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $usuarios = User::all();
        $destinatariosSeleccionados = $notificacion->destinatarios->pluck('id')->toArray();

        return view('notificaciones.edit', compact('notificacion', 'usuarios', 'destinatariosSeleccionados'));
    }

    // Actualizar notificación
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'es_global' => 'required|boolean',
            'usuarios' => 'nullable|array',
        ]);

        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update([
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'es_global' => $request->es_global,
        ]);

        if (!$request->es_global) {
            $notificacion->destinatarios()->sync($request->usuarios);
        } else {
            $notificacion->destinatarios()->detach(); // borrar destinatarios si ahora es global
        }

        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada correctamente.');
    }

    // Desactivar notificación
    public function destroy($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update(['status' => 0]);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación desactivada correctamente.');
    }

    // Activar notificación
    public function activate($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update(['status' => 1]);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación activada correctamente.');
    }

    // Mostrar detalles
    public function show($id)
    {
        $user = auth()->user();
        $notificacion = Notificacion::with('creador', 'destinatarios')->findOrFail($id);

        // Si no es global, buscar el registro y marcar como leído
        if (!$notificacion->es_global) {
            $registro = NotificacionUser::where('notificacion_id', $id)
                ->where('user_id', $user->id)
                ->first();

            if ($registro && !$registro->leido) {
                $registro->leido = true;
                $registro->save();
            }
        }

        return view('notificaciones.show', compact('notificacion'));
    }

}
