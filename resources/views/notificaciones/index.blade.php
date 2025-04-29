<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Panel de Notificaciones</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3 text-end">
            <a href="{{ route('notificaciones.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Nueva Notificación
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Mensaje</th>
                        <th>Estado</th>
                        <th>Tipo</th>
                        <th>Creado por</th>
                        <th>Creado en</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notificaciones as $notificacion)
                        <tr>
                            <td>{{ $notificacion->id }}</td>
                            <td>{{ $notificacion->titulo }}</td>
                            <td>{{ Str::limit($notificacion->mensaje, 50) }}</td>
                            <td>
                                @if ($notificacion->status)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                {{ $notificacion->es_global ? 'Global' : 'Personalizada' }}
                            </td>
                            <td>{{ $notificacion->creador->name ?? 'N/A' }}</td>
                            <td>{{ $notificacion->created_at->format('d/m/Y H:i') }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('notificaciones.show', $notificacion->id) }}"
                                    class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('notificaciones.edit', $notificacion->id) }}"
                                    class="btn btn-sm btn-warning">Editar</a>

                                @if ($notificacion->status)
                                    <form method="POST" action="{{ route('notificaciones.destroy', $notificacion->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Desactivar esta notificación?')">Desactivar</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('notificaciones.activate', $notificacion->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-success"
                                            onclick="return confirm('¿Activar esta notificación?')">Activar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay notificaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>