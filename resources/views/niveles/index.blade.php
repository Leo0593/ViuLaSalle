<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Niveles</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Niveles</h1>
        <a href="{{ route('niveles.create') }}" class="btn btn-success mb-3">Crear Nivel</a>

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
                            <a href="{{ route('niveles.edit', $nivel->id) }}" class="btn btn-primary">Editar</a>

                            @if ($nivel->status == 1)
                                <!-- Botón de eliminar con un formulario -->
                                <form action="{{ route('niveles.destroy', $nivel->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas desactivar este Nivel Academico?')">Eliminar</button>
                                </form>
                            @else
                                <!-- Botón de activar con un formulario -->
                                <form action="{{ route('niveles.activate', $nivel->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas activar este Nivel Academico?')">Activar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>