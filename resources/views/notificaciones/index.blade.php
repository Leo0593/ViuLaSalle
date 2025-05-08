@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container mt-5 pt-5">
        <div class="container mt-4 pt-4"></div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <div class="bg-white p-3 p-md-4 rounded-3 mb-3 mb-md-4 shadow-sm border">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 gap-md-0">
                <!-- Texto del título -->
                <div class="w-100">
                    <h1 class="h4 h3-md mb-1">
                        <i class="fas fa-bell me-2 me-md-3 text-primary"></i>
                        <span class="d-inline-block">Panel de Notificaciones</span>
                    </h1>
                    <p class="text-muted mb-0 small d-none d-sm-block">
                        Administra todas las notificaciones de tu sistema
                    </p>
                    <p class="text-muted mb-0 small d-block d-sm-none">
                        Administrar notificaciones
                    </p>
                </div>

                <!-- Botones - versión desktop (derecha) -->
                <div class="d-none d-md-flex align-items-center ms-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#crearNotificacionModal">
                        <i class="fas fa-plus me-2"></i>Crear Notificación
                    </button>

                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-arrow-left me-2"></i> Volver
                    </a>
                </div>

                <!-- Botón crear - versión móvil (debajo del texto) -->
                <div class="d-block d-md-none w-100 mt-2">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-primary btn-sm flex-grow-1 flex-md-grow-0"
                            data-bs-toggle="modal" data-bs-target="#crearNotificacionModal">
                            <i class="fas fa-plus me-1"></i> Crear
                        </button>

                        <a href="{{ route('dashboard') }}"
                            class="btn btn-outline-secondary btn-sm flex-grow-1 flex-md-grow-0">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros de búsqueda - Versión mejorada -->
        <div class="bg-white p-4 rounded-3 mb-4 shadow-sm border">
            <h5 class="mb-3 text-primary">
                <i class="fas fa-filter me-2"></i>Filtrar Notificaciones
            </h5>

            <form method="GET" action="{{ route('notificaciones.index') }}" class="row g-3 align-items-end">
                <!-- Filtro por título -->
                <div class="col-md-4 col-lg-3">
                    <label for="titulo" class="form-label small text-muted">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control form-control-sm"
                        placeholder="Buscar por título..." value="{{ request('titulo') }}">
                </div>

                <!-- Filtro por estado -->
                <div class="col-md-3 col-lg-2">
                    <label for="status" class="form-label small text-muted">Estado</label>
                    <select name="status" id="status" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <!-- Filtro por creador -->
                <div class="col-md-4 col-lg-3">
                    <label for="creador" class="form-label small text-muted">Creador</label>
                    <input type="text" name="creador" id="creador" class="form-control form-control-sm"
                        placeholder="Buscar por creador..." value="{{ request('creador') }}">
                </div>

                <!-- Filtro por rango de fechas -->
                <div class="col-md-5 col-lg-4">
                    <label class="form-label small text-muted d-block">Rango de fechas</label>
                    <div class="input-group input-group-sm">
                        <input type="date" name="fecha_inicio" class="form-control form-control-sm"
                            value="{{ request('fecha_inicio') }}" aria-label="Fecha inicio">
                        <span class="input-group-text bg-light">a</span>
                        <input type="date" name="fecha_fin" class="form-control form-control-sm"
                            value="{{ request('fecha_fin') }}" aria-label="Fecha fin">
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="col-md-4 col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                        <i class="fas fa-filter me-1"></i> Aplicar
                    </button>
                    <a href="{{ route('notificaciones.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-undo me-1"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tarjetas de notificaciones -->
        <div class="bg-light p-3 p-md-4 rounded-4 mb-4 shadow-sm">
            @if($notificaciones->isEmpty())
                <div class="text-center py-4 py-md-5">
                    <i class="fas fa-bell-slash fa-2x fa-md-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay notificaciones registradas</h4>
                </div>
            @else
                <div class="row">
                    @foreach ($notificaciones as $notificacion)
                        <div class="col-12 mb-3 mb-md-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <!-- Layout para pantallas grandes -->
                                    <div class="d-none d-md-flex">
                                        <!-- Contenido principal -->
                                        <div class="flex-grow-1 pe-3">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h5 class="card-title mb-0">{{ $notificacion->titulo }}</h5>
                                                <span
                                                    class="badge rounded-pill {{ $notificacion->status ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $notificacion->status ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </div>

                                            <span class="badge bg-info mb-2">
                                                {{ $notificacion->es_global ? 'Global' : 'Personalizada' }}
                                            </span>

                                            <p class="card-text text-muted mb-3">
                                                {{ Str::limit($notificacion->mensaje, 100) }}
                                            </p>

                                            <div class="d-flex justify-content-between text-muted small">
                                                <div>
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $notificacion->creador->name ?? 'N/A' }}
                                                </div>
                                                <div>
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $notificacion->created_at->format('d/m/Y') }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Botones de acción -->
                                        <div class="d-flex flex-column justify-content-between" style="min-width: 120px;">
                                            <button class="btn btn-sm btn-outline-primary mb-2 ver-notificacion"
                                                data-url="{{ route('notificaciones.show', $notificacion->id) }}">
                                                <i class="fas fa-eye me-1"></i> Ver
                                            </button>

                                            <a href="{{ route('notificaciones.edit', $notificacion->id) }}"
                                                class="btn btn-sm btn-outline-warning mb-2">
                                                <i class="fas fa-edit me-1"></i> Editar
                                            </a>

                                            @if ($notificacion->status)
                                                <form method="POST"
                                                    action="{{ route('notificaciones.destroy', $notificacion->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger w-100"
                                                        onclick="return confirm('¿Desactivar esta notificación?')">
                                                        <i class="fas fa-toggle-off me-1"></i> Desactivar
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('notificaciones.activate', $notificacion->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-sm btn-outline-success w-100"
                                                        onclick="return confirm('¿Activar esta notificación?')">
                                                        <i class="fas fa-toggle-on me-1"></i> Activar
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Layout para móviles -->
                                    <div class="d-flex flex-column d-md-none">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-0">{{ $notificacion->titulo }}</h5>
                                            <span
                                                class="badge rounded-pill {{ $notificacion->status ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $notificacion->status ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-info">
                                                {{ $notificacion->es_global ? 'Global' : 'Personalizada' }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $notificacion->created_at->format('d/m/Y') }}
                                            </small>
                                        </div>

                                        <p class="card-text text-muted mb-3">
                                            {{ Str::limit($notificacion->mensaje, 80) }}
                                        </p>

                                        <div class="mb-2 text-muted small">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $notificacion->creador->name ?? 'N/A' }}
                                        </div>

                                        <!-- Botones en horizontal para móviles -->
                                        <div class="d-flex gap-2 mt-2">
                                            <button class="btn btn-sm btn-outline-primary flex-grow-1 ver-notificacion"
                                                data-url="{{ route('notificaciones.show', $notificacion->id) }}">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-sm-inline"> Ver</span>
                                            </button>

                                            <a href="{{ route('notificaciones.edit', $notificacion->id) }}"
                                                class="btn btn-sm btn-outline-warning flex-grow-1">
                                                <i class="fas fa-edit"></i>
                                                <span class="d-none d-sm-inline"> Editar</span>
                                            </a>

                                            @if ($notificacion->status)
                                                <form method="POST"
                                                    action="{{ route('notificaciones.destroy', $notificacion->id) }}"
                                                    class="flex-grow-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger w-100"
                                                        onclick="return confirm('¿Desactivar esta notificación?')">
                                                        <i class="fas fa-toggle-off"></i>
                                                        <span class="d-none d-sm-inline"> Desactivar</span>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('notificaciones.activate', $notificacion->id) }}"
                                                    class="flex-grow-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-sm btn-outline-success w-100"
                                                        onclick="return confirm('¿Activar esta notificación?')">
                                                        <i class="fas fa-toggle-on"></i>
                                                        <span class="d-none d-sm-inline"> Activar</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-3 mt-md-4">
                    {{ $notificaciones->links() }}
                </div>
            @endif
        </div>
    
        <!-- Modal de creación -->
        <div class="modal fade" id="crearNotificacionModal" tabindex="-1" aria-labelledby="crearNotificacionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="crearNotificacionModalLabel">Crear Nueva Notificación</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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

                        <form action="{{ route('notificaciones.store') }}" method="POST" id="notificacionForm">
                            @csrf

                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="titulo" id="titulo"
                                    value="{{ old('titulo') }}" required
                                    placeholder="Ingrese el título de la notificación">
                            </div>

                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" name="mensaje" id="mensaje" rows="5" required
                                    placeholder="Escriba el contenido de la notificación">{{ old('mensaje') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tipo de notificación <span
                                        class="text-danger">*</span></label>
                                <select name="es_global" id="es_global" class="form-select" required
                                    onchange="toggleUsuarios(this.value)">
                                    <option value="" disabled selected>Seleccione el tipo</option>
                                    <option value="1" {{ old('es_global') == 1 ? 'selected' : '' }}>Notificación global
                                        (para todos los usuarios)</option>
                                    <option value="0" {{ old('es_global') == 0 ? 'selected' : '' }}>Notificación
                                        personalizada (seleccionar usuarios)</option>
                                </select>
                            </div>

                            <div class="mb-3" id="usuarios_select" style="display: none;">
                                <label class="form-label">Seleccionar usuarios</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" id="buscar_usuario" class="form-control"
                                        placeholder="Buscar usuario por nombre o email..." onkeyup="filtrarUsuarios()">
                                </div>

                                <div class="border rounded p-2 bg-light" style="max-height: 250px; overflow-y: auto;">
                                    <div id="usuarios_checklist">
                                        @foreach ($usuarios as $usuario)
                                            <div class="form-check usuario-item mb-2"
                                                data-nombre="{{ strtolower($usuario->name) }} {{ strtolower($usuario->email) }}">
                                                <input class="form-check-input usuario-checkbox" type="checkbox"
                                                    name="usuarios[]" value="{{ $usuario->id }}"
                                                    id="usuario_{{ $usuario->id }}" {{ is_array(old('usuarios')) && in_array($usuario->id, old('usuarios')) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="usuario_{{ $usuario->id }}">
                                                    <strong>{{ $usuario->name }}</strong> <small
                                                        class="text-muted">{{ $usuario->email }}</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <small class="text-muted">Seleccione los usuarios que recibirán esta
                                    notificación</small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                        <button type="submit" form="notificacionForm" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Guardar Notificación
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Ver Notificación -->
        <div class="modal fade" id="verNotificacionModal" tabindex="-1" aria-labelledby="verNotificacionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verNotificacionModalLabel">Detalle de la Notificación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalVerContent">
                        <!-- El contenido se cargará aquí dinámicamente -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>



    </div>


</body>

<!-- ENCARGADO DE MOSTRAR EL APARTADO DE CREATE -->

<script>
    function toggleUsuarios(valor) {
        const usuariosSelect = document.getElementById('usuarios_select');
        usuariosSelect.style.display = valor == "0" ? 'block' : 'none';

        // Si no es global, hacer scroll al área de usuarios
        if (valor == "0") {
            setTimeout(() => {
                usuariosSelect.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        }
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
        // Inicializar según el valor actual (para cuando hay errores de validación)
        const esGlobal = document.getElementById('es_global');
        if (esGlobal) {
            toggleUsuarios(esGlobal.value);
        }

        // Configurar eventos para los checkboxes
        document.querySelectorAll('.usuario-checkbox').forEach(cb => {
            cb.addEventListener('change', reordenarUsuarios);
        });

        // Reordenar inicialmente si hay usuarios seleccionados
        reordenarUsuarios();

        // Manejar el modal cuando se muestra
        $('#crearNotificacionModal').on('shown.bs.modal', function () {
            document.getElementById('titulo').focus();
        });
    });
</script>

<!-- ENCARGADO DE MOSTRAR EL APARTADO DE SHOW -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.ver-notificacion').forEach(button => {
            button.addEventListener('click', function () {
                const url = this.getAttribute('data-url');

                document.getElementById('modalVerContent').innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2">Cargando notificación...</p>
                    </div>
                `;

                const modal = new bootstrap.Modal(document.getElementById('verNotificacionModal'));
                modal.show();

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const wrapper = doc.querySelector('.modal-content-wrapper');

                        if (wrapper) {
                            document.getElementById('modalVerContent').innerHTML = wrapper.innerHTML;
                        } else {
                            document.getElementById('modalVerContent').innerHTML = `
                                <div class="alert alert-warning">No se encontró el contenido de la notificación.</div>
                            `;
                        }
                    })
                    .catch(error => {
                        document.getElementById('modalVerContent').innerHTML = `
                            <div class="alert alert-danger">
                                Error al cargar la notificación: ${error.message}
                            </div>
                        `;
                    });
            });
        });
    });
</script>


</html>