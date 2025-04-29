<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Editar Notificación</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Hay algunos problemas con tu entrada:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notificaciones.update', $notificacion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" name="titulo" id="titulo"
                    value="{{ old('titulo', $notificacion->titulo) }}" required>
            </div>

            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea class="form-control" name="mensaje" id="mensaje" rows="4"
                    required>{{ old('mensaje', $notificacion->mensaje) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">¿Es global?</label>
                <select name="es_global" id="es_global" class="form-select" required
                    onchange="toggleUsuarios(this.value)">
                    <option value="1" {{ $notificacion->es_global ? 'selected' : '' }}>Sí, para todos</option>
                    <option value="0" {{ !$notificacion->es_global ? 'selected' : '' }}>No, seleccionar usuarios
                    </option>
                </select>
            </div>

            <div class="mb-3" id="usuarios_select" style="display: {{ !$notificacion->es_global ? 'block' : 'none' }};">
                <label for="usuarios" class="form-label">Seleccionar usuarios</label>
                <select name="usuarios[]" id="usuarios" class="form-select" multiple>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ in_array($usuario->id, $notificacion->destinatarios->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $usuario->name }} ({{ $usuario->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-end">
                <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Notificación</button>
            </div>
        </form>
    </div>

    <script>
        function toggleUsuarios(valor) {
            document.getElementById('usuarios_select').style.display = valor == "0" ? 'block' : 'none';
        }

        document.addEventListener("DOMContentLoaded", function () {
            toggleUsuarios(document.getElementById('es_global').value);
        });
    </script>
</body>

</html>