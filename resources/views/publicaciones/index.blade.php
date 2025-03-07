<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Publicaciones</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        img { width: 100px; height: auto; margin-right: 5px; }
        .foto-container { display: flex; flex-wrap: wrap; gap: 10px; }
    </style>
</head>
<body>

<h2>Lista de Publicaciones</h2>

<a href="{{ route('publicaciones.create') }}" class="btn btn-success mb-3">Crear publicacion</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Evento</th>
            <th>Descripción</th>
            <th>Fecha Publicación</th>
            <th>Fotos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($publicaciones as $publicacion)
        <tr>
            <td>{{ $publicacion->id }}</td>
            <td>{{ $publicacion->usuario->name }}</td>
            <td>{{ $publicacion->evento->nombre }}</td>
            <td>{{ $publicacion->descripcion }}</td>
            <td>{{ $publicacion->fecha_publicacion }}</td>
            <td>
                <div class="foto-container">
                    @foreach ($publicacion->fotos as $foto)
                        <img src="{{ asset('storage/' . $foto->ruta_foto) }}" alt="Foto">
                    @endforeach
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
