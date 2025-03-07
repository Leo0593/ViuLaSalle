<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">

        <h1 class="mb-4">Lista de Usuarios</h1>
        <a href="{{ route('eventos.create') }}" class="btn btn-success mb-3">Crear Eventor</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Visible</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Fecha Publicacion</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventos as $evento)
                    <tr>
                        <td>{{ $evento->id }}</td>
                        <td>{{ $evento->id_user }}</td>
                        <td>{{ $evento->visible }}</td>
                        <td>
                            @if($evento->visible)
                                <span class="badge bg-success">Visible</span>
                            @else
                                <span class="badge bg-danger">No visible</span>
                            @endif
                        </td>
                        <td>{{ $evento->nombre }}</td>
                        <td>{{ $evento->descripcion }}</td>
                        <td>{{ $evento->fecha_publicacion }}</td>

                        <td>
                            @if($evento->foto)
                                <img src="{{ Storage::url($evento->foto) }}" alt="Foto" width="auto" height="100">
                            @else
                                <span>Sin foto</span>
                            @endif
                        </td>

                        <td>
                            editar
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>