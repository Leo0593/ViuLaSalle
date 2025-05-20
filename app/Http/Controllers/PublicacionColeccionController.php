<?php

namespace App\Http\Controllers;

use App\Models\PublicacionColeccion;
use App\Models\FotoColeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\SafeSearchAnnotation;
use Google\Cloud\Vision\V1\Likelihood;


class PublicacionColeccionController extends Controller
{

    public function create(Request $request)
    {
        $coleccion_id = $request->get('coleccion_id');
        return view('publicaciones_coleccion.create', compact('coleccion_id'));
    }


    public function store(Request $request)
    {
        // Establecer las credenciales de Google Cloud Vision
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('credentials/clave.json'));

        $request->validate([
            'descripcion' => 'required|string',
            'coleccion_id' => 'required|exists:colecciones,id',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $publicacion = PublicacionColeccion::create([
            'user_id' => auth()->id(),
            'coleccion_id' => $request->coleccion_id, // <- esto es clave
            'descripcion' => $request->descripcion,
            'fecha_publicacion' => now(),
            'status' => 1,
        ]);


        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $ruta = $foto->store('fotos_coleccion', 'public');

                // Analizar imagen con Google Vision
                $resultadoVision = $this->analizarImagenConVision($ruta);

                if ($this->esContenidoInapropiado($resultadoVision)) {
                    // Eliminar la publicación y la imagen
                    $publicacion->delete();
                    Storage::disk('public')->delete($ruta);

                    return redirect()->route('colecciones.show', $request->coleccion_id)->with('error', 'La imagen contiene contenido inapropiado.');
                }

                FotoColeccion::create([
                    'publicacion_coleccion_id' => $publicacion->id,
                    'ruta_foto' => $ruta,
                ]);
            }
        }

        return redirect()->route('colecciones.show', $request->coleccion_id)->with('success', 'Publicación creada exitosamente.');
    }

    public function edit(string $id)
    {
        $publicacion = PublicacionColeccion::findOrFail($id);
        return view('publicaciones_coleccion.edit', compact('publicacion'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $publicacion = PublicacionColeccion::findOrFail($id);
        $publicacion->update([
            'descripcion' => $request->descripcion,
        ]);

        // Eliminar fotos seleccionadas
        if ($request->has('fotos_eliminar')) {
            foreach ($request->fotos_eliminar as $fotoId) {
                $foto = FotoColeccion::find($fotoId);
                if ($foto && $foto->publicacion_coleccion_id == $publicacion->id) {
                    // Eliminar archivo físico
                    Storage::disk('public')->delete($foto->ruta_foto);
                    // Eliminar de la base de datos
                    $foto->delete();
                }
            }
        }


        // Manejo de las fotos, si es necesario actualizarlas.
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $ruta = $foto->store('fotos_coleccion', 'public');
                FotoColeccion::create([
                    'publicacion_coleccion_id' => $publicacion->id,
                    'ruta_foto' => $ruta,
                ]);
            }
        }

        return redirect()->route('colecciones.show', $publicacion->coleccion_id)->with('success', 'Publicación actualizada correctamente.');
    }



    public function destroy(string $id)
    {
        $publicacion = PublicacionColeccion::findOrFail($id);
        $publicacion->update(['status' => 0]);
        return redirect()->route('colecciones.show', $publicacion->coleccion_id)->with('success', 'Publicación desactivada correctamente.');
    }

    public function activate(string $id)
    {
        $publicacion = PublicacionColeccion::findOrFail($id);
        $publicacion->update(['status' => 1]);
        return redirect()->route('colecciones.show', $publicacion->coleccion_id)->with('success', 'Publicación activada correctamente.');
    }





    /*Metodos Extras para las publicaciones*/

    protected function analizarImagenConVision($rutaFoto)
    {
        $client = new ImageAnnotatorClient();

        $imageContent = file_get_contents(storage_path('app/public/' . $rutaFoto));

        $image = new Image();
        $image->setContent($imageContent);

        $feature = new Feature();
        $feature->setType(Feature\Type::SAFE_SEARCH_DETECTION);

        $response = $client->annotateImage($image, [$feature]);

        $safeSearch = $response->getSafeSearchAnnotation();

        $client->close();

        return $safeSearch;
    }

    protected function esContenidoInapropiado(SafeSearchAnnotation $safeSearch)
    {
        return (
            $safeSearch->getAdult() === Likelihood::VERY_LIKELY ||
            $safeSearch->getViolence() === Likelihood::VERY_LIKELY ||
            $safeSearch->getRacy() === Likelihood::VERY_LIKELY
        );
    }

}
