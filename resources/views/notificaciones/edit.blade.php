@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container mt-5 pt-5">
        <div class="container mt-5 pt-5"></div>
        
        <!-- Tarjeta principal con esquinas redondeadas -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <!-- Encabezado de la tarjeta -->
            <div class="card-header bg-white border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-light text-primary mb-2">
                            <i class="fas fa-edit me-1"></i> Editar Notificación
                        </span>
                        <h3 class="fw-bold mb-0">Editar Notificación</h3>
                    </div>
                </div>
            </div>
            
            <!-- Cuerpo de la tarjeta -->
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <strong>Oops!</strong> Hay algunos problemas con tu entrada:<br><br>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('notificaciones.update', $notificacion->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Sección Título -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small mb-2 d-flex align-items-center">
                            <i class="fas fa-heading me-2"></i> Título
                        </h6>
                        <input type="text" class="form-control rounded-3" name="titulo" id="titulo"
                            value="{{ old('titulo', $notificacion->titulo) }}" required>
                    </div>

                    <!-- Sección Mensaje -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small mb-2 d-flex align-items-center">
                            <i class="fas fa-envelope me-2"></i> Mensaje
                        </h6>
                        <textarea class="form-control rounded-3" name="mensaje" id="mensaje" rows="8"
                            required>{{ old('mensaje', $notificacion->mensaje) }}</textarea>
                    </div>

                    <!-- Sección Tipo -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small mb-2 d-flex align-items-center">
                            <i class="fas fa-globe me-2"></i> Tipo de Notificación
                        </h6>
                        <select name="es_global" id="es_global" class="form-select rounded-3" required
                            onchange="toggleUsuarios(this.value)">
                            <option value="1" {{ $notificacion->es_global ? 'selected' : '' }}>Global (para todos los usuarios)</option>
                            <option value="0" {{ !$notificacion->es_global ? 'selected' : '' }}>Personalizada (seleccionar usuarios específicos)</option>
                        </select>
                    </div>

                    <!-- Sección Usuarios (condicional) -->
                    <div class="mb-4" id="usuarios_select" style="display: {{ !$notificacion->es_global ? 'block' : 'none' }};">
                        <h6 class="text-uppercase text-muted small mb-2 d-flex align-items-center">
                            <i class="fas fa-users me-2"></i> Seleccionar Usuarios
                        </h6>
                        
                        <div class="mb-3">
                            <input type="text" id="buscar_usuario" class="form-control rounded-3 mb-2" placeholder="Buscar usuario por nombre o email..."
                                onkeyup="filtrarUsuarios()">
                        </div>

                        <div class="bg-light p-3 rounded-3 border" style="max-height: 350px; overflow-y: auto;">
                            <div id="usuarios_checklist">
                                @foreach ($usuarios as $usuario)
                                    <div class="form-check usuario-item ml-4 p-2 rounded-2 hover-light align-items-center"
                                        data-nombre="{{ strtolower($usuario->name) }} {{ strtolower($usuario->email) }}">
                                        <input class="form-check-input usuario-checkbox me-3" type="checkbox" name="usuarios[]"
                                            value="{{ $usuario->id }}" id="usuario_{{ $usuario->id }}"
                                            {{ in_array($usuario->id, $notificacion->destinatarios->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center w-100" for="usuario_{{ $usuario->id }}">
                                            <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                {{ substr($usuario->name, 0, 1) }}
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">{{ $usuario->name }}</div>
                                                <small class="text-muted">{{ $usuario->email }}</small>
                                            </div>
                                            <span class="badge bg-secondary rounded-pill">#{{ $usuario->id }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="text-end mt-4 pt-2 border-top">
                        <a href="{{ route('notificaciones.index') }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-1"></i> Actualizar Notificación
                        </button>
                    </div>
                </form>
            </div>
        </div>
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

            contenedor.innerHTML = '';
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

