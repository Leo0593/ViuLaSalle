<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Publicación</title>
</head>
<body>

<h2>Crear Publicación</h2>

<form action="{{ route('publicaciones.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Selección del Usuario (asumimos que se selecciona de una lista de usuarios) -->
    <label for="id_user">Usuario:</label>
    <select name="id_user" required>
        @foreach ($usuarios as $usuario)
            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
        @endforeach
    </select><br><br>

    <!-- Selección del Evento (asumimos que se selecciona de una lista de eventos) -->
    <label for="id_evento">Evento:</label>
    <select name="id_evento">
        @foreach ($eventos as $evento)
            <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
        @endforeach
    </select><br><br>

    <!-- Descripción de la publicación -->
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" required></textarea><br><br>

    <!-- Fecha de publicación -->
    <label for="fecha_publicacion">Fecha de Publicación:</label>
    <input type="date" name="fecha_publicacion" required><br><br>

    <!-- Fotos -->
    <label for="fotos">Fotos (puedes seleccionar varias):</label>
    <input type="file" name="fotos[]" accept="image/*" multiple><br><br>

    <!-- Botón de Enviar -->
    <button type="submit">Crear Publicación</button>
</form>

</body>
</html>
