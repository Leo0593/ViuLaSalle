<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon; // Para obtener la fecha actual
use App\Models\FotoPublicacion;
use App\Models\VideoPublicacion;
use App\Models\Categoria;
use App\Models\Publicacion;
use App\Models\Contenido;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $nombre = $request->input('nombre');
        $status = $request->input('status');

        $query = Evento::query();

        if (!$user || $user->role != 'ADMIN') {
            $query->where('status', 1); // Solo visibles para no admin
        }

        $query->when($nombre, function ($q) use ($nombre) {
            $q->where('nombre', 'like', '%' . $nombre . '%');
        });

        if ($status !== null) {
            $query->where('status', $status);
        }

        $eventos = $query->paginate(6)->appends($request->except('page'));

        return view('eventos.index', compact('eventos', 'user'));
    }


    public function todoseventos()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $publicaciones = null; // Inicializar publicaciones como nul

        $eventos = Evento::where('status', 1)->get();

        return view('eventos.todoseventos', compact('eventos', 'publicaciones')); // Retornar vista con datos
    }

    public function create()
    {
        return view('eventos.create'); // Devuelve la vista para crear un evento
    }

    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp,|max:2048', // Validación para archivos de imagen
        ]);

        // Obtener el usuario autenticado
        $user_id = auth()->id(); // Obtiene el ID del usuario autenticado

        // Subir la foto y obtener la ruta
        $fotoPath = $request->file('foto')->store('eventos', 'public'); // Guarda la foto en la carpeta public/eventos

        // Crear un nuevo evento
        $evento = new Evento();
        $evento->nombre = $validated['nombre'];
        $evento->descripcion = $validated['descripcion'];
        $evento->fecha_publicacion = now(); // Asigna la fecha y hora actuales
        $evento->foto = $fotoPath; // Guarda la ruta de la foto
        $evento->user_id = $user_id; // Asigna el ID del usuario autenticado
        $evento->status = 1; // Se podría configurar según sea necesario, o tomar del formulario
        $evento->save(); // Guardar el evento

        return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente.');
    }

    public function edit($id)
    {
        $evento = Evento::findOrFail($id); // Busca el evento por ID
        $contenidos = $evento->contenido()
            ->where('vista_tipo', 'evento')
            /*->where('status', 1)*/
            ->orderBy('created_at', 'asc')
            ->get();

        return view('eventos.edit', compact('evento', 'contenidos')); // Retorna la vista de edición con el evento y sus contenidos
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,|max:2048', // La foto es opcional
        ]);

        // Buscar el evento
        $evento = Evento::findOrFail($id);

        // Actualizar los datos del evento
        $evento->nombre = $validated['nombre'];
        $evento->descripcion = $validated['descripcion'];

        // Si se sube una nueva foto, eliminar la anterior y guardar la nueva
        if ($request->hasFile('foto')) {
            // Eliminar la foto anterior
            if ($evento->foto && \Storage::disk('public')->exists($evento->foto)) {
                \Storage::disk('public')->delete($evento->foto);
            }

            // Guardar la nueva foto
            $fotoPath = $request->file('foto')->store('eventos', 'public');
            $evento->foto = $fotoPath;
        }

        $evento->save(); // Guardar los cambios

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    // Método para ocultar un evento (desactivarlo)
    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->status = 0; // Ocultar el evento
        $evento->save();

        return redirect()->route('eventos.index')->with('success', 'El evento ha sido ocultado correctamente.');
    }

    // Método para activar un evento
    public function activate($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->status = 1; // Activar el evento
        $evento->save();

        return redirect()->route('eventos.index')->with('success', 'El evento ha sido activado correctamente.');
    }

    //show por id
    public function show($id)
    {
        $evento = Evento::findOrFail($id); // Busca el evento por ID

        $user = auth()->user(); // Obtener el usuario autenticado

        $eventos = Evento::where('status', 1)->get(); // Solo eventos visibles para los demás
        $publicaciones = Publicacion::with(['fotos', 'videos', 'categorias'])
            ->where('status', 1)
            ->orderBy('fecha_publicacion', 'desc') // Ordenar por fecha de publicación (más recientes primero)
            ->get();

        $contenidos = $evento->contenido()
            ->where('vista_tipo', 'evento')
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('eventos.show', compact('evento', 'publicaciones', 'user', 'contenidos')); // Retornar vista con datos
    }
}
