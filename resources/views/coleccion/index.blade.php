<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANEL DE COLECCIONES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">BIENVENIDO AL PANEL DE COLECCIONES</h1>

        <!-- Botón para crear una nueva colección -->
        <a href="{{ route('colecciones.create') }}" class="btn btn-primary mb-4">
            <i class="fa-solid fa-plus"></i> Crear Nueva Colección
        </a>

        <!-- Tabla que lista las colecciones -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Usuarios</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($colecciones as $coleccion)
                    <tr>
                        <td>{{ $coleccion->id }}</td>
                        <td>{{ $coleccion->nombre }}</td>
                        <td>{{ $coleccion->descripcion ?? 'No disponible' }}</td>
                        <td>
                            @foreach($coleccion->usuarios as $usuario)
                                <span class="badge bg-info">{{ $usuario->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <!-- ver mas colección -->
                            <a href="{{ route('colecciones.show', $coleccion->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-edit"></i> Ver Mas
                            </a>

                            <!-- Editar colección -->
                            <a href="{{ route('colecciones.edit', $coleccion->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-edit"></i> Editar
                            </a>

                            <!-- Eliminar colección -->
                            @if ($coleccion->status)
                                <form method="POST" action="{{ route('colecciones.destroy', $coleccion->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Desactivar esta notificación?')">Desactivar</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('colecciones.activate', $coleccion->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-success"
                                        onclick="return confirm('¿Activar esta notificación?')">Activar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>