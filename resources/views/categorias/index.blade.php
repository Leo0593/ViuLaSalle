@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container mt-header pt-3">
        <div class="bg-white p-4 rounded-4 mb-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1"><i class="fas fa-tags me-3 text-primary"></i> Lista de Etiquetas</h1>
                    <p class="text-muted mb-0">Administra todas las Etiquetas de tu sistema</p>
                </div>
                <div>
                    <!-- Botón para Crear Categoria -->
                    <a href="javascript:void(0);" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i class="fas fa-plus-circle me-2"></i> Crear Categoria
                    </a>

                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros de búsqueda y estado -->
        <div class="bg-light p-4 rounded-4 mb-4 shadow-sm">

            <form method="GET" action="{{ route('categorias.index') }}" class="row mb-4">
                <div class="col-md-5 mb-2">
                    <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre..."
                        value="{{ request('nombre') }}">
                </div>

                <div class="col-md-3 mb-2">
                    <select name="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="col-md-2 d-grid mb-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Filtrar
                    </button>
                </div>

                <div class="col-md-2 d-grid mb-2">
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>



        <div class="bg-light p-4 rounded-4 mb-4 shadow-sm">
            <div class="row">
                @foreach ($categorias as $categoria)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex align-items-start">
                                <!-- Icono más grande y azul cuando está activo -->
                                <div class="d-flex align-items-center justify-content-center me-4"
                                    style="width: 60px; height: 100%;">
                                    <i
                                        class="fas fa-tag fa-2x {{ $categoria->status ? 'text-primary' : 'text-secondary' }}"></i>
                                </div>

                                <!-- Contenido principal -->
                                <div class="flex-grow-1">
                                    <p class="card-text text-muted mb-1">ID: {{ $categoria->id }}</p>
                                    <h5 class="card-title mb-2">{{ $categoria->nombre }}</h5>

                                    <!-- Badge de status -->
                                    <span
                                        class="badge rounded-pill mb-3 {{ $categoria->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $categoria->status ? 'Activo' : 'Inactivo' }}
                                    </span>

                                    <!-- Botones centrados con espacio -->
                                    <div class="d-flex justify-content-center gap-3">

                                        <div class="text-center" style="width: 45%;">
                                            <button type="button" class="btn btn-sm btn-outline-primary w-100"
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                onclick="loadCategoryData({{ $categoria->id }})">
                                                <i class="fas fa-edit me-1"></i> Editar
                                            </button>
                                        </div>

                                        <div class="text-center" style="width: 45%;">
                                            @if ($categoria->status == 1)
                                                <!-- Botón de desactivar -->
                                                <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                                        onclick="return confirm('¿Estás seguro de que deseas desactivar esta categoría?')">
                                                        <i class="fas fa-toggle-off me-1"></i> Desactivar
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Botón de activar -->
                                                <form action="{{ route('categorias.activate', $categoria->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-success w-100"
                                                        onclick="return confirm('¿Estás seguro de que deseas activar esta categoría?')">
                                                        <i class="fas fa-toggle-on me-1"></i> Activar
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $categorias->links() }}
            </div>
        </div>

        <!-- Modal para Editar Categoria -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"> <!-- Agregamos la clase modal-dialog-centered aquí -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <button type="submit" class="btn btn-primary">Editar Categoria</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Crear Categoria -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"> <!-- Centrado vertical y horizontal -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Crear Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('categorias.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <button type="submit" class="btn btn-primary">Crear Categoria</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function loadCategoryData(id) {
            // Usamos Ajax para obtener los datos de la categoría
            fetch(`/categorias/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Llenamos el formulario con los datos de la categoría
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('editForm').action = `/categorias/${id}`;
                })
                .catch(error => console.log(error));
        }
    </script>

</body>

</html>