<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Notificación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Detalle de Notificación</h2>

        <div class="mb-3">
            <strong>Título:</strong>
            <p>{{ $notificacion->titulo }}</p>
        </div>

        <div class="mb-3">
            <strong>Mensaje:</strong>
            <p>{{ $notificacion->mensaje }}</p>
        </div>

        <div class="mb-3">
            <strong>¿Es global?:</strong>
            <p>{{ $notificacion->es_global ? 'Sí, para todos' : 'No, usuarios seleccionados' }}</p>
        </div>

        @if (!$notificacion->es_global)
            <div class="mb-3">
                <strong>Destinatarios:</strong>
                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                    <ul class="list-group">
                        @foreach ($notificacion->destinatarios as $usuario)
                            <li class="list-group-item">
                                {{ $usuario->name }} ({{ $usuario->email }})
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</body>
</html>
