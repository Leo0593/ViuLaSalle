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
    <div class="container mt-5">
        <h1>Crear Publicación</h1>

        <form action="{{ route('publicaciones.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id_user">Usuario</label>
                <select name="id_user" id="id_user" class="form-control">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_evento">Evento</label>
                <select name="id_evento" id="id_evento" class="form-control">
                    @foreach($eventos as $evento)
                        <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Crear Publicación</button>
        </form>

        <a href="{{ route('publicaciones.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </div>
</body>
</html>
