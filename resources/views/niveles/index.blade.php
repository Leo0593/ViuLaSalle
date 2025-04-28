<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Niveles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Niveles</h1>

        @auth
            @if(auth()->user()->role == 'ADMIN')
                <a href="{{ route('niveles.create') }}" class="btn btn-success mb-3">Crear Nivel</a>
                <a href="{{ route('dashboard') }}" class="btn btn-success mb-3">Volver a Dashboard</a>
            @endif
        @endauth

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($niveles as $nivel)
                    <tr>
                        <td>{{ $nivel->id }}</td>
                        <td>{{ $nivel->nombre }}</td>
                        <td>
                            <a href="{{ route('cursos.index', ['nivel' => $nivel->nombre]) }}" class="btn btn-info btn-sm">
                                Ver Cursos
                            </a>

                            @auth
                                @if(auth()->user()->role == 'ADMIN')
                                    <a href="{{ route('niveles.edit', $nivel->id) }}" class="btn btn-primary btn-sm">Editar</a>

                                    @if ($nivel->status == 1)
                                        <form action="{{ route('niveles.destroy', $nivel->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de que deseas desactivar este Nivel Educativo?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('niveles.activate', $nivel->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('¿Estás seguro de que deseas activar este Nivel Educativo?')">
                                                Activar
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endauth

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
