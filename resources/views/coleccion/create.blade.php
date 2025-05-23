@include('layouts.head')

<body class="bg-light">
    @include('layouts.navheader')
    <div class="container mt-5">
        <h1>Crear Nueva Colección</h1>
        <!-- Formulario para crear colección -->
        <form action="{{ route('colecciones.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Colección</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>

            <div class="mb-3" id="usuarios_select">
                <input type="text" id="buscar_usuario" class="form-control mb-2" placeholder="Buscar usuario..."
                    onkeyup="filtrarUsuarios()">
                <!-- Contenedor interno que tiene scroll si la lista crece -->
                <div id="usuarios_checklist" class="border rounded p-2" style="max-height: 100px; overflow-y: auto;">
                    @foreach ($users as $user)
                        <div class="form-check usuario-item"
                            data-nombre="{{ strtolower($user->name) }} {{ strtolower($user->email) }}">
                            <input class="form-check-input usuario-checkbox" type="checkbox" name="usuarios[]"
                                value="{{ $user->id }}" id="user_{{ $user->id }}">
                            <label class="form-check-label" for="user_{{ $user->id }}">
                                {{ $user->name }} ({{ $user->email }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Crear Colección</button>
        </form>
    </div>

    <!-- Scripts de Bootstrap y búsqueda de usuarios -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para filtrar los usuarios por nombre y correo
        function filtrarUsuarios() {
            const input = document.getElementById('buscar_usuario').value.toLowerCase();
            const items = document.querySelectorAll('.usuario-item');

            items.forEach(item => {
                const nombre = item.getAttribute('data-nombre');
                item.style.display = nombre.includes(input) ? 'block' : 'none';
            });
        }

        // Función para reordenar la lista, moviendo los usuarios seleccionados al principio
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
            // Reordenar usuarios cuando se cambia el estado de un checkbox
            document.querySelectorAll('.usuario-checkbox').forEach(cb => {
                cb.addEventListener('change', reordenarUsuarios);
            });
        });
    </script>
</body>

</html>