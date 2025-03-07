<!-- resources/views/publicaciones/index.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Publicaciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Listado de Publicaciones</h1>
        <a href="{{ route('publicaciones.create') }}" class="btn btn-primary mb-3">Crear Publicación</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Fecha de Publicación</th>
                    <th>Usuario</th>
                    <th>Evento</th>
                    <th>Status</th>
                    <th>Fotos</th> <!-- Columna nueva para mostrar las fotos -->
                </tr>
            </thead>
            <tbody>
                @foreach($publicaciones as $publicacion)
                    <tr>
                        <td>{{ $publicacion->id }}</td>
                        <td>{{ $publicacion->descripcion }}</td>
                        <td>{{ $publicacion->fecha_publicacion->format('d/m/Y') }}</td>
                        <td>{{ $publicacion->usuario->name }}</td> <!-- Suponiendo que el usuario tiene un campo 'name' -->
                        <td>{{ $publicacion->evento->nombre }}</td>
                        <!-- Suponiendo que el evento tiene un campo 'nombre' -->
                        <td>{{ $publicacion->status }}</td>

                        <!-- Columna de fotos -->
                        <td>
                            @if($publicacion->fotos->count() > 0)
                                <div class="row">
                                    @foreach($publicacion->fotos as $foto)
                                        <div class="col-md-3">
                                            <!-- Mostrar las fotos con la ruta correcta usando Storage::url() -->
                                            <img src="{{ Storage::url('public/publicaciones/' . $foto->ruta_foto) }}" alt="Foto"
                                                class="img-fluid">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>No hay fotos</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
