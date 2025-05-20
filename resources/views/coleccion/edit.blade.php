@include('layouts.head')

<body class="bg-light-gray">
    @include('layouts.navheader')

    <div class="container py-5" style="max-width: 800px; margin-top: 200px;">
        <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
            <!-- Encabezado con degradado -->
            <div class="card-header bg-gradient-primary py-3">
                <h2 class="card-title text-white mb-0">
                    <i class="fas fa-edit me-2"></i>Editar Colección
                </h2>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <!-- Mostrar errores si existen -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <h5 class="alert-heading mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Error en el formulario</h5>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('colecciones.update', $coleccion->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Campo Nombre -->
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-semibold text-dark">
                            <i class="fas fa-tag me-1 text-primary"></i>Nombre de la Colección
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-heading text-muted"></i></span>
                            <input type="text" class="form-control form-control-lg border-start-0" id="nombre" name="nombre"
                                value="{{ old('nombre', $coleccion->nombre) }}" required placeholder="Escribe el nombre aquí">
                        </div>
                        <div class="form-text text-muted small">Máximo 100 caracteres</div>
                    </div>

                    <!-- Campo Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold text-dark">
                            <i class="fas fa-align-left me-1 text-primary"></i>Descripción
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light align-items-start pt-2"><i class="fas fa-pen text-muted"></i></span>
                            <textarea class="form-control border-start-0" id="descripcion" name="descripcion" rows="4"
                                placeholder="Describe la colección">{{ old('descripcion', $coleccion->descripcion) }}</textarea>
                        </div>
                        <div class="form-text text-muted small">Opcional - Máximo 500 caracteres</div>
                    </div>

                    <!-- Selector de Usuarios -->
                    <div class="mb-4" id="usuarios_select">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-users me-1 text-primary"></i>Usuarios con acceso
                        </label>
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="buscar_usuario" class="form-control" placeholder="Buscar usuario por nombre o email..."
                                onkeyup="filtrarUsuarios()">
                        </div>

                        <div id="usuarios_checklist" class="border rounded p-3 bg-white shadow-sm" style="max-height: 250px; overflow-y: auto;">
                            @foreach ($users as $user)
                                <div class="form-check usuario-item py-2 px-3 mb-1 rounded hover-bg" data-nombre="{{ strtolower($user->name) }} {{ strtolower($user->email) }}">
                                    <input class="form-check-input usuario-checkbox" type="checkbox" name="usuarios[]"
                                        value="{{ $user->id }}" id="user_{{ $user->id }}"
                                        @if(in_array($user->id, $coleccion->usuarios->pluck('id')->toArray())) checked @endif>
                                    <label class="form-check-label ms-3 d-flex align-items-center" for="user_{{ $user->id }}">
                                        <span class="avatar-sm me-2 d-flex align-items-center justify-content-center bg-primary text-white rounded-circle">
                                            {{ substr($user->name, 0, 1) }}
                                        </span>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            <small class="text-muted d-block">{{ $user->email }}</small>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-text text-muted small">Selecciona los usuarios que tendrán acceso a esta colección</div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
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
            document.querySelectorAll('.usuario-checkbox').forEach(cb => {
                cb.addEventListener('change', reordenarUsuarios);
            });
            
            // Validación de formulario
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
    
    <style>
        .bg-light-gray {
            background-color: #f8f9fa;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }
        .hover-bg:hover {
            background-color: #f1f7ff;
        }
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 14px;
            font-weight: 600;
        }
        .card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        }
        .form-control:focus, .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .usuario-checkbox:checked {
            background-color: #224abe;
            border-color: #224abe;
        }
    </style>
</body>
</html>