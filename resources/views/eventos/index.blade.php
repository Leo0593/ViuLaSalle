@include('layouts.head')

<body>

    @include('layouts.navheader')
    
    <div class="body-container container">
        <div class="bg-light p-4 rounded-4 mb-4 shadow-sm">

            <div class="text-center my-5">
                <h1 class="display-5 fw-bold">Gestión de Eventos</h1>
                <p class="lead text-muted">Aquí puedes ver, crear y editar eventos registrados en el sistema.</p>
            </div>

            <!-- Botones de acción -->
            <div class="d-flex justify-content-center gap-3 mb-4">
                <div class="col-md-2">
                    <a href="{{ route('eventos.create') }}" class="btn btn-success">
                        <i class="fa fa-user-plus me-1"></i> Crear Usuario
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Volver a Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="eventos-organizados">
        @foreach ($eventos as $evento)
            <a class="evento-container" style=" background-image: linear-gradient(to top, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0)), url('{{ Storage::url($evento->foto) }}');"
                href="{{ route('eventos.show', $evento->id) }}">
                <div class="evento-texto">
                    <h2>{{ $evento->nombre }}</h2>
                    <p>{{ Str::limit($evento->descripcion, 200, '...') }}</p>
                </div>
            </a>
        @endforeach
    </div>

</body>

<!--
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuariods</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Eventos</h1>

        <form method="GET" action="{{ route('eventos.index') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                    value="{{ request('nombre') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">-- Estado de visibilidad --</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Visible</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>No visible</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>

        <a href="{{ route('eventos.create') }}" class="btn btn-success mb-3">Crear Eventor</a>
        <a href="{{ route('dashboard') }}" class="btn btn-success mb-3">Volver a Dashboard</a>

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
                                    Botón de desactivar 
                                    <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('¿Estás seguro de que deseas ocultar este evento?')">Desactivar</button>
                                    </form>
                                @else
                                     Botón de activar 
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

-->