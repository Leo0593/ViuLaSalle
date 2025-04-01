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

        <h1 class="mb-4">Lista de Eventos</h1>
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
                        <td>{{ $evento->user_id }}</td>
                        <td>
                            @if($evento->status)
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
                            @if ($user->role == 'ADMIN' || $user->id == $evento->user_id)
                                <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-primary">Editar</a>
                                @if ($evento->status == 1)
                                    <!-- Botón de desactivar -->
                                    <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('¿Estás seguro de que deseas ocultar este evento?')">Desactivar</button>
                                    </form>
                                @else
                                    <!-- Botón de activar -->
                                    <form action="{{ route('eventos.activate', $evento->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('¿Estás seguro de que deseas activar este evento?')">Activar</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>