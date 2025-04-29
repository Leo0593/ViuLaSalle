<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Crear Notificación</h2>

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

        <form action="{{ route('notificaciones.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" name="titulo" id="titulo" value="{{ old('titulo') }}" required>
            </div>

            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea class="form-control" name="mensaje" id="mensaje" rows="4"
                    required>{{ old('mensaje') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">¿Es global?</label>
                <select name="es_global" id="es_global" class="form-select" required
                    onchange="toggleUsuarios(this.value)">
                    <option value="1" {{ old('es_global') == 1 ? 'selected' : '' }}>Sí, para todos</option>
                    <option value="0" {{ old('es_global') == 0 ? 'selected' : '' }}>No, seleccionar usuarios</option>
                </select>
            </div>

            <div class="mb-3" id="usuarios_select" style="display: none;">
                <input type="text" id="buscar_usuario" class="form-control mb-2" placeholder="Buscar usuario..."
                    onkeyup="filtrarUsuarios()">
                <!-- Contenedor externo que limita la altura -->
                <div class="border rounded p-3" style="max-height: 350px; overflow-y: auto;">
                    <!-- Contenedor interno que tiene scroll si la lista crece -->
                    <div id="usuarios_checklist" class="border rounded p-2"
                        style="max-height: 80px; overflow-y: auto;">
                        @foreach ($usuarios as $usuario)
                            <div class="form-check usuario-item mb-1"
                                data-nombre="{{ strtolower($usuario->name) }} {{ strtolower($usuario->email) }}">
                                <input class="form-check-input usuario-checkbox" type="checkbox" name="usuarios[]"
                                    value="{{ $usuario->id }}" id="usuario_{{ $usuario->id }}">
                                <label class="form-check-label" for="usuario_{{ $usuario->id }}">
                                    {{ $usuario->name }} ({{ $usuario->email }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Notificación</button>
            </div>
        </form>
    </div>

    <script>
        function toggleUsuarios(valor) {
            document.getElementById('usuarios_select').style.display = valor == "0" ? 'block' : 'none';
        }

        function filtrarUsuarios() {
            const input = document.getElementById('buscar_usuario').value.toLowerCase();
            const items = document.querySelectorAll('.usuario-item');

            items.forEach(item => {
                const nombre = item.getAttribute('data-nombre');
                item.style.display = nombre.includes(input) ? 'block' : 'none';
            });
        }

        function reordenarUsuarios() {
            const contenedor = document.getElementById('usuarios_checklist');
            const items = Array.from(contenedor.querySelectorAll('.usuario-item'));

            const seleccionados = items.filter(i => i.querySelector('input').checked);
            const noSeleccionados = items.filter(i => !i.querySelector('input').checked);

            // Limpiar contenedor
            contenedor.innerHTML = '';

            // Agregar seleccionados primero
            seleccionados.forEach(i => contenedor.appendChild(i));
            noSeleccionados.forEach(i => contenedor.appendChild(i));
        }

        document.addEventListener("DOMContentLoaded", function () {
            toggleUsuarios(document.getElementById('es_global').value);

            document.querySelectorAll('.usuario-checkbox').forEach(cb => {
                cb.addEventListener('change', reordenarUsuarios);
            });
        });

    </script>
</body>

</html>