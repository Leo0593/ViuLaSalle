<!-- resources/views/publicaciones/create.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Publicación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- Mostrar la alerta si hay un mensaje de error en la sesión -->
    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    <div class="container mt-5">
        <h1>Crear Publicación</h1>
        <a href="{{ route('publicaciones.index') }}" class="btn btn-secondary mb-3">Volver</a>

        <form action="{{ route('publicaciones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">


            <div class="form-group">
                <label for="id_evento">Evento</label>
                <select name="id_evento" id="id_evento" class="form-control" required>
                    <option value="" selected disabled>Selecciona un evento</option> <!-- Opción inicial -->
                    @foreach($eventos as $evento)
                        <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="fotos">Fotos</label>
                <input type="file" name="fotos[]" id="fotos" class="form-control" multiple required>
            </div>

            @if ($user && ($user->role == 'PROFESOR' || $user->role == 'ADMIN'))
                <div class="form-group">
                    <label for="videos">Videos</label>
                    <input type="file" name="videos[]" id="videos" class="form-control" multiple>
                </div>
            @endif

            <div class="form-group form-check">
                <input type="checkbox" name="activar_comentarios" id="activar_comentarios" class="form-check-input"
                    value="1">
                <label class="form-check-label" for="activar_comentarios">Permitir comentarios</label>
            </div>



            <button type="submit" class="btn btn-primary">Guardar Publicación</button>
        </form>
    </div>
</body>

</html>