<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>

<body>

    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    <div class="container">
        <form action="{{ route('publicaciones.update', $publicacion->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="id_user" class="form-label">Usuario</label>
                <select name="id_user" class="form-control">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ $usuario->id == $publicacion->id_user ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_evento" class="form-label">Evento</label>
                <select name="id_evento" class="form-control">
                    @foreach($eventos as $evento)
                        <option value="{{ $evento->id }}" {{ $evento->id == $publicacion->id_evento ? 'selected' : '' }}>
                            {{ $evento->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required>{{ $publicacion->descripcion }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Fotos Actuales</label>
                <div>
                    @foreach($publicacion->fotos as $foto)
                        <div class="d-inline-block me-2">
                            <img src="{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}" width="100" class="me-2">
                            <div>
                                <input type="checkbox" name="delete_photos[]" value="{{ $foto->id }}"> Eliminar
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="fotos" class="form-label">Nuevas Fotos (Opcional)</label>
                <input type="file" name="fotos[]" class="form-control" multiple>
            </div>

            @if ($user && ($user->role == 'PROFESOR' || $user->role == 'ADMIN'))
                <div class="mb-3">
                    <label class="form-label">Videos Actuales</label>
                    <div>
                        @foreach($publicacion->videos as $video)
                            <div class="d-inline-block me-2">
                                <video width="100" controls>
                                    <source src="{{ asset('storage/publicvideos/' . $video->ruta_video) }}" type="video/mp4">
                                    Tu navegador no soporta la reproducción de videos.
                                </video>
                                <div>
                                    <input type="checkbox" name="delete_videos[]" value="{{ $video->id }}"> Eliminar
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label for="videos" class="form-label">Nuevos Videos (Opcional)</label>
                    <input type="file" name="videos[]" class="form-control" multiple accept="video/*">
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>

</body>

</html>