<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\NotificacionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotificacionCreada;


class NotificacionController extends Controller
{
    // Mostrar listado de notificaciones
    public function index(Request $request)
    {
        $user = auth()->user();
        $usuarios = User::all();

        // Obtener filtros
        $titulo = $request->input('titulo');
        $status = $request->input('status');
        $creadorNombre = $request->input('creador');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $query = Notificacion::with('creador');

        // Filtro por rol
        if ($user->role === 'ADMIN') {
            // Sin restricciones por destinatarios
        } elseif ($user->role === 'PROFESOR') {
            $query->where('status', 1)
                ->where(function ($q) use ($user) {
                    $q->where('es_global', true)
                        ->orWhere('creador_id', $user->id)
                        ->orWhereHas('destinatarios', function ($q2) use ($user) {
                            $q2->where('user_id', $user->id);
                        });
                });
        } else {
            $query->where('status', 1)
                ->where(function ($q) use ($user) {
                    $q->where('es_global', true)
                        ->orWhereHas('destinatarios', function ($q2) use ($user) {
                            $q2->where('user_id', $user->id);
                        });
                });
        }

        // Aplicar filtros si están presentes
        if (!empty($titulo)) {
            $query->where('titulo', 'like', "%$titulo%");
        }

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        if (!empty($creadorNombre)) {
            $query->whereHas('creador', function ($q) use ($creadorNombre) {
                $q->where('name', 'like', "%$creadorNombre%");
            });
        }
        
        if ($fechaInicio) {
            $query->whereDate('created_at', '>=', $fechaInicio);
        }
        
        if ($fechaFin) {
            $query->whereDate('created_at', '<=', $fechaFin);
        }

        // Obtener resultados paginados con filtros mantenidos
        $notificaciones = $query->latest()
            ->paginate(5)
            ->appends($request->except('page'));

        return view('notificaciones.index', compact('notificaciones', 'usuarios'));
    }



    public function create()
    {
        $usuarios = User::all(); // para  seleccionar destinatarios si es necesario
        return view('notificaciones.create', compact('usuarios'));
    }

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

            // Enviar correo a cada usuario seleccionado
            $usuarios = User::whereIn('id', $request->usuarios)->get();
            foreach ($usuarios as $usuario) {
                $usuario->notify(new NotificacionCreada($notificacion->titulo, $notificacion->mensaje));
            }
        } elseif ($request->es_global) {
            // Enviar a todos los usuarios activos excepto al creador
            $usuarios = User::where('id', '!=', Auth::id())->get();
            foreach ($usuarios as $usuario) {
                $usuario->notify(new NotificacionCreada($notificacion->titulo, $notificacion->mensaje));
            }
        }

        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada y enviada por correo.');
    }

    public function edit($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $usuarios = User::all();
        $destinatariosSeleccionados = $notificacion->destinatarios->pluck('id')->toArray();


        return view('notificaciones.edit', compact('notificacion', 'usuarios', 'destinatariosSeleccionados'));
    }

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

    public function destroy($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update(['status' => 0]);
        return redirect()->route('notificaciones.index')->with('success', 'Notificación desactivada correctamente.');
    }

    public function activate($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update(['status' => 1]);
        return redirect()->route('notificaciones.index')->with('success', 'Notificación activada correctamente.');
    }

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
