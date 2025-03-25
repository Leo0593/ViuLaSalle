<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use App\Models\User;
use App\Models\Evento;
use Carbon\Carbon; // Para obtener la fecha actual
use App\Models\FotoPublicacion;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\SafeSearchAnnotation;
use Google\Cloud\Vision\V1\Likelihood; // Importar la clase Likelihood
use Illuminate\Support\Facades\Storage;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Reporte;


class PublicacionController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'ADMIN') {
            $publicaciones = Publicacion::with('fotos')->get();
        } else {
            $publicaciones = Publicacion::with('fotos')->where('status', 1)->get();
        }

        // Retornar la vista con las publicaciones filtradas
        return view('publicaciones.index', compact('publicaciones', 'user'));
    }

    public function create()
    {
        // Obtener todos los usuarios y eventos disponibles
        $usuarios = User::all();
        $eventos = Evento::all();

        // Retornar la vista con los datos
        return view('publicaciones.create', compact('usuarios', 'eventos'));
    }

    public function store(Request $request)
    {
        // Establecer las credenciales de Google Cloud Vision usando el archivo JSON
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('credentials/clave.json'));

        // Validar los datos del formulario
        $request->validate([
            'id_user' => 'required|exists:users,id',       // Verifica que el usuario exista
            'id_evento' => 'required|exists:eventos,id',   // Verifica que el evento exista
            'descripcion' => 'required|string|max:255',    // Descripción es obligatoria y tiene un límite de caracteres
            'fotos' => 'nullable|array',                    // Aceptar un array de fotos
            'fotos.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación para las fotos
            'activar_comentarios' => 'nullable|boolean',
        ]);

        // Crear la publicación (y guardarla en la base de datos)
        $publicacion = Publicacion::create([
            'id_user' => auth()->user()->id,  // Usar el ID del usuario logueado
            'id_evento' => $request->id_evento,
            'descripcion' => $request->descripcion,
            'fecha_publicacion' => Carbon::now(), // Fecha actual
            'status' => 1, // Estado por defecto es 1
            'activar_comentarios' => $request->has('activar_comentarios') ? 1 : 0,
        ]);

        // Subir las fotos y procesarlas
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                // Guardar cada foto en el directorio 'public/publicaciones' y obtener la ruta
                $rutaFoto = $foto->store('publicaciones', 'public');  // Aquí se cambia el nombre del directorio a 'publicaciones'

                // Usar Google Cloud Vision para analizar la imagen
                $resultadoVision = $this->analizarImagenConVision($rutaFoto);

                // Verificar si la imagen tiene contenido inapropiado
                if ($this->esContenidoInapropiado($resultadoVision)) {
                    // Si se detecta contenido inapropiado, eliminamos la publicación y mostramos un mensaje
                    $publicacion->delete(); // Eliminamos la publicación de la base de datos
                    return redirect()->route('publicaciones.create')->with('error', 'La imagen contiene contenido inapropiado.');
                }

                // Crear una nueva entrada en la tabla de fotos asociada a la publicación
                FotoPublicacion::create([
                    'publicacion_id' => $publicacion->id, // Aquí utilizamos el ID de la publicación guardada
                    'ruta_foto' => basename($rutaFoto), // Guardamos solo el nombre del archivo
                ]);
            }
        }

        // Redirigir a la lista de publicaciones con un mensaje de éxito
        return redirect()->route('publicaciones.index')->with('success', 'Publicación creada correctamente.');
    }
    public function edit($id)
    {
        $publicacion = Publicacion::with('fotos')->findOrFail($id); // Buscar la publicación con sus fotos
        $usuarios = User::all(); // Obtener lista de usuarios
        $eventos = Evento::all(); // Obtener lista de eventos

        return view('publicaciones.edit', compact('publicacion', 'usuarios', 'eventos'));
    }

    public function update(Request $request, $id)
    {
        // Establecer credenciales de Google Cloud Vision
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('credentials/clave.json'));

        $publicacion = Publicacion::findOrFail($id);

        // Validación de los datos
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_evento' => 'required|exists:eventos,id',
            'descripcion' => 'required|string|max:255',
            'fotos' => 'nullable|array',
            'fotos.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Actualizar los datos de la publicación
        $publicacion->update([
            'id_user' => $request->id_user,
            'id_evento' => $request->id_evento,
            'descripcion' => $request->descripcion,
            'fecha_publicacion' => Carbon::now(),
        ]);

        // Eliminar fotos seleccionadas
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $foto_id) {
                $foto = FotoPublicacion::find($foto_id);
                if ($foto) {
                    // Eliminar el archivo de almacenamiento
                    Storage::delete('public/publicaciones/' . $foto->ruta_foto);
                    // Eliminar la entrada de la base de datos
                    $foto->delete();
                }
            }
        }

        // Manejo de fotos (agregar nuevas)
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $rutaFoto = $foto->store('publicaciones', 'public'); // Guardar en almacenamiento

                // Analizar con Google Vision
                $resultadoVision = $this->analizarImagenConVision($rutaFoto);
                if ($this->esContenidoInapropiado($resultadoVision)) {
                    return redirect()->route('publicaciones.edit', $id)->with('error', 'La imagen contiene contenido inapropiado.');
                }

                // Guardar la nueva foto en la base de datos
                FotoPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'ruta_foto' => basename($rutaFoto),
                ]);
            }
        }

        return redirect()->route('publicaciones.index')->with('success', 'Publicación actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        // Buscar la publicación por su ID
        $publicacion = Publicacion::findOrFail($id);

        // Cambiar el estado de la publicación de 1 a 0
        $publicacion->update(['status' => 0]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('publicaciones.index')->with('success', 'Publicación desactivada correctamente.');
    }

    public function activate(string $id)
    {
        // Buscar la publicación por su ID
        $publicacion = Publicacion::findOrFail($id);

        // Cambiar el estado de la publicación de 0 a 1 (activar)
        $publicacion->update(['status' => 1]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('publicaciones.index')->with('success', 'Publicación activada correctamente.');
    }


    public function show(string $id)
    {
       
    }

    // FUNCIONES ADICIONALES

    protected function analizarImagenConVision($rutaFoto)
    {
        // Crear un cliente de Vision
        $client = new ImageAnnotatorClient();

        // Cargar la imagen como contenido binario
        $imageContent = file_get_contents(storage_path('app/public/' . $rutaFoto));

        // Crear el objeto de imagen y establecer su contenido como una cadena de texto (binary data)
        $image = new Image();
        $image->setContent($imageContent);  // Debemos pasar los datos binarios correctamente

        // Definir las características que quieres analizar (seguridad)
        $feature = new Feature();
        $feature->setType(Feature\Type::SAFE_SEARCH_DETECTION);

        // Realizar la solicitud a Google Cloud Vision
        $response = $client->annotateImage($image, [$feature]);

        // Obtener la anotación de seguridad (SAFE_SEARCH_DETECTION)
        $safeSearch = $response->getSafeSearchAnnotation();

        // Cerrar el cliente
        $client->close();

        return $safeSearch;
    }

    protected function esContenidoInapropiado(SafeSearchAnnotation $safeSearch)
    {
        // Definir los umbrales para determinar si la imagen es inapropiada
        if (
            $safeSearch->getAdult() == Likelihood::VERY_LIKELY ||
            $safeSearch->getViolence() == Likelihood::VERY_LIKELY ||
            $safeSearch->getRacy() == Likelihood::VERY_LIKELY
        ) {
            return true; // La imagen contiene contenido inapropiado
        }

        return false; // La imagen es segura
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

    public function reportar($id)
    {
        $user = auth()->user();

        // Verificar si el usuario ya reportó esta publicación
        if (Reporte::where('user_id', $user->id)->where('publicacion_id', $id)->exists()) {
            return back()->with('error', 'Ya has reportado esta publicación.');
        }

        // Registrar el reporte
        Reporte::create([
            'user_id' => $user->id,
            'publicacion_id' => $id
        ]);

        // Obtener la publicación y actualizar el contador de reportes
        $publicacion = Publicacion::findOrFail($id);
        $publicacion->increment('reportes');

        // Si la publicación alcanza 3 reportes, cambiar su estado a inactivo (0)
        if ($publicacion->reportes >= 3) {
            $publicacion->update(['status' => 0]);
        }

        return back()->with('success', 'Publicación reportada correctamente.');
    }


}
