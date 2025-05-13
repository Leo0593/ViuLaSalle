@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container">

        <div class="container py-4">
            <!-- Hero Section -->
            <div class="body-container hero-section p-4 mb-4 rounded-4 shadow-sm"
                style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);">
                <div class="container text-center">
                    <h1 class="display-5 fw-bold text-dark mb-3">Gestión de Eventos</h1>
                    <p class="lead text-muted mb-4">Aquí puedes ver, crear y editar eventos registrados en el sistema.
                    </p>
                </div>
            </div>

            <!-- Header with Actions -->
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 p-3 bg-white rounded-3 shadow-sm">
                <h2 class="mb-3 mb-md-0 fw-semibold">Listado de Eventos</h2>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary create-btn" data-bs-toggle="modal"
                        data-bs-target="#crearEventoModal">
                        <i class="fas fa-plus me-2"></i>Crear Evento
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>


        <div class="bg-white p-4 rounded-3 mb-4 shadow-sm border border-light">
            <form method="GET" action="{{ route('eventos.index') }}" class="row g-3 align-items-end">
                <!-- Título -->
                <div class="col-12 mb-2">
                    <h5 class="text-primary mb-0">
                        <i class="fas fa-sliders-h me-2"></i>Filtrar Eventos
                    </h5>
                    <hr class="mt-2 mb-3">
                </div>

                <!-- Buscar por nombre -->
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="nombre" class="form-control shadow-sm"
                            placeholder="Buscar por nombre..." value="{{ request('nombre') }}">
                        <label for="nombre">Nombre del evento</label>
                    </div>
                </div>

                <!-- Estado -->
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="status" class="form-select shadow-sm">
                            <option value="">-- Estado de visibilidad --</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Visible</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>No visible</option>
                        </select>
                        <label for="status">Estado</label>
                    </div>
                </div>

                <!-- Botones -->
                <div class="col-md-4 d-flex gap-2 align-self-end">
                    <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-broom me-1"></i> Limpiar
                    </a>
                    <button type="submit" class="btn btn-primary w-100 shadow">
                        <i class="fas fa-filter me-1"></i> Aplicar Filtros
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white p-4 rounded-3 mb-4 shadow-sm border border-light">

            @if($eventos->isEmpty())
                <div class="alert alert-info">No se encontraron eventos.</div>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($eventos as $evento)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                @if($evento->foto)
                                    <img src="{{ Storage::url($evento->foto) }}" class="card-img-top" alt="{{ $evento->nombre }}"
                                        style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                                        style="height: 200px;">
                                        <span class="text-white">Sin imagen</span>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ $evento->nombre }}</h5>
                                        @if($evento->status)
                                            <span class="badge bg-success">Visible</span>
                                        @else
                                            <span class="badge bg-danger">No visible</span>
                                        @endif
                                    </div>
                                    <p class="card-text text-muted small">{{ Str::limit($evento->descripcion, 100) }}</p>
                                    <p class="card-text"><small class="text-muted">Publicado:
                                            {{ $evento->fecha_publicacion }}</small></p>
                                </div>

                                @if ($user->role == 'ADMIN' || $user->id == $evento->user_id)
                                    <div class="card-footer bg-transparent border-0 position-relative">
                                        <div class="position-absolute bottom-0 end-0 mb-2 me-2">
                                            <button type="button" class="btn btn-sm btn-primary me-1 btn-abrir-editar-modal"
                                                data-id="{{ $evento->id }}" data-url="{{ route('eventos.edit', $evento->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </button>


                                            @if ($evento->status == 1)
                                                <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('¿Estás seguro de que deseas ocultar este evento?')">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('eventos.activate', $evento->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        onclick="return confirm('¿Estás seguro de que deseas activar este evento?')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-3 mt-md-4">
                    {{ $eventos->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Modal para Crear Evento -->
    <div class="modal fade" id="crearEventoModal" tabindex="-1" aria-labelledby="crearEventoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Hacemos el modal más ancho -->
            <div class="modal-content rounded-4 shadow">

                <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data" class="p-0">
                    @csrf

                    <!-- Header -->
                    <div class="modal-header bg-primary text-white rounded-top-4 px-4 py-3">
                        <h5 class="modal-title fw-semibold" id="crearEventoModalLabel">
                            <i class="fas fa-calendar-plus me-2"></i> Crear Nuevo Evento
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body px-4 py-3 bg-light rounded-bottom">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row g-3">

                            <div class="col-12">
                                <label for="nombre" class="form-label fw-medium">Nombre del Evento</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-heading"></i></span>
                                    <input type="text" class="form-control shadow-sm" id="nombre" name="nombre"
                                        value="{{ old('nombre') }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="descripcion" class="form-label fw-medium">Descripción</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-align-left"></i></span>
                                    <textarea class="form-control shadow-sm" id="descripcion" name="descripcion"
                                        rows="4" required>{{ old('descripcion') }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="foto" class="form-label fw-medium">Foto del Evento</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-image"></i></span>
                                    <input type="file" class="form-control shadow-sm" id="foto" name="foto" required>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer bg-white px-4 py-3 rounded-bottom-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i> Crear Evento
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal para Editar Evento -->
    <div class="modal fade" id="editarEventoModal" tabindex="-1" aria-labelledby="editarEventoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarEventoModalLabel">Editar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="editarEventoModalBody">
                    <!-- Aquí se cargará la vista de edición vía AJAX -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const botones = document.querySelectorAll('.btn-abrir-editar-modal');

            botones.forEach(btn => {
                btn.addEventListener('click', function () {
                    const url = this.dataset.url;
                    const modalBody = document.getElementById('editarEventoModalBody');

                    // Mostrar loader
                    modalBody.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                `;

                    // Abrir modal
                    const modal = new bootstrap.Modal(document.getElementById('editarEventoModal'));
                    modal.show();

                    // Cargar contenido vía AJAX
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            modalBody.innerHTML = html;
                        })
                        .catch(error => {
                            modalBody.innerHTML = `<div class="alert alert-danger">Error al cargar el formulario.</div>`;
                            console.error('Error al cargar la vista de edición:', error);
                        });
                });
            });
        });
    </script>





    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            border-radius: 0.375rem 0.375rem 0 0;
        }
    </style>
</body>