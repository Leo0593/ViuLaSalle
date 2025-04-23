<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de cursos</title>
</head>

<body>
    <h1>Tabla de cursos</h1>
    @if($user->role == 'ADMIN')
        <a href="{{ route('cursos.create') }}">
            <button>Crear curso</button>
        </a>

        <a href="{{ route('dashboard') }}" class="btn btn-success mb-3">Volver a Dashboard</a>

    @endif


    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Nivel educativo</th>
                <th>Estado</th>
                <th>Imágenes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cursos as $curso)
                <tr>
                    <td>{{ $curso->id }}</td>
                    <td>{{ $curso->nombre }}</td>
                    <td>{{ $curso->nivelEducativo->nombre ?? 'N/A' }}</td>
                    <td>{{ $curso->status ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        @if($curso->fotos->count())
                            @foreach($curso->fotos as $foto)
                                <img src="{{ asset('storage/' . $foto->ruta_imagen) }}" alt="foto curso" width="80"
                                    style="margin: 5px;">
                            @endforeach
                        @else
                            <span>Sin imágenes</span>
                        @endif
                    </td>
                    <td>
                        @if($user->role == 'ADMIN')

                            <a href="{{ route('cursos.edit', $curso->id) }}">
                                <button>Editar</button>
                            </a>

                            @if($curso->status)
                                <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('¿Estás seguro de desactivar este curso?')">Desactivar</button>
                                </form>
                            @else
                                <form action="{{ route('cursos.activate', $curso->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" onclick="return confirm('¿Deseas activar este curso?')">Activar</button>
                                </form>
                            @endif
                        @endif

                    </td>


                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay cursos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>