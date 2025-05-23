@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container pt-3">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="container">
            <!-- Hero Section -->
            <div class="body-container hero-section p-4 mb-4 rounded-4 shadow-sm"
                style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);">
                <div class="container text-center">
                    <h1 class="display-5 fw-bold text-dark mb-3">Gestión de Cursos</h1>
                    <p class="lead text-muted mb-4">Administra todos los cursos de tu sistema</p>
                </div>
            </div>

            <!-- Header with Actions -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 p-3 bg-white rounded-3 shadow-sm">
                <h2 class="mb-3 mb-md-0 fw-semibold">Listado de Cursos</h2>
                <div class="d-flex gap-2">
                    @auth
                        @if($user->role == 'ADMIN')
                            <a href="{{ route('cursos.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear Curso
                            </a>
                        @endif
                    @endauth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros de búsqueda -->
        <div class="bg-white p-4 rounded-3 mb-4 shadow-sm border border-light">
            <form method="GET" action="{{ route('cursos.index') }}" class="row g-3 align-items-end">
                <!-- Título -->
                <div class="col-12 mb-2">
                    <h5 class="text-primary mb-0">
                        <i class="fas fa-sliders-h me-2"></i>Filtrar Cursos
                    </h5>
                    <hr class="mt-2 mb-3">
                </div>

                <!-- Filtro por nombre -->
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="nombre" id="nombre" class="form-control shadow-sm"
                            placeholder="Buscar por nombre..." value="{{ request('nombre') }}">
                        <label for="nombre">Nombre del Curso</label>
                    </div>
                </div>

                <!-- Filtro por estado -->
                <div class="col-md-2">
                    <div class="form-floating">
                        <select name="status" id="status" class="form-select shadow-sm">
                            <option value="">Todos</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        <label for="status">Estado</label>
                    </div>
                </div>

                <!-- Rango de fechas -->
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">Rango de fechas</label>
                    <div class="input-group">
                        <input type="date" name="fecha_inicio" class="form-control shadow-sm"
                            value="{{ request('fecha_inicio') }}" aria-label="Fecha inicio">
                        <span class="input-group-text bg-light">a</span>
                        <input type="date" name="fecha_fin" class="form-control shadow-sm"
                            value="{{ request('fecha_fin') }}" aria-label="Fecha fin">
                    </div>
                </div>

                <!-- Botones -->
                <div class="col-md-2 d-flex gap-2 align-self-end">
                    <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-broom me-1"></i> Limpiar
                    </a>
                    <button type="submit" class="btn btn-primary shadow w-100">
                        <i class="fas fa-filter me-1"></i> Aplicar
                    </button>
                </div>
            </form>
        </div>

        <!-- Tarjetas de cursos -->
        <div class="bg-light p-3 p-md-4 rounded-4 mb-4 shadow-sm">
            @if($cursos->isEmpty())
                <div class="text-center py-4 py-md-5">
                    <i class="fas fa-book fa-2x fa-md-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay cursos registrados</h4>
                    @auth
                        @if($user->role == 'ADMIN')
                            <a href="{{ route('cursos.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>Crear Primer Curso
                            </a>
                        @endif
                    @endauth
                </div>
            @else
                <div class="row">
                    @foreach ($cursos as $curso)
                        <div class="col-12 mb-3 mb-md-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <!-- Layout para pantallas grandes -->
                                    <div class="d-none d-md-flex">
                                        <!-- Imagen del curso -->
                                        <div class="flex-shrink-0 me-3" style="width: 120px;">
                                            @if($curso->img)
                                                <img src="{{ asset('storage/' . $curso->img) }}" 
                                                    class="img-fluid rounded" 
                                                    alt="Imagen del curso"
                                                    style="max-height: 100px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary d-flex align-items-center justify-content-center rounded"
                                                    style="width: 120px; height: 100px;">
                                                    <i class="fas fa-book fa-2x text-light"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Contenido principal -->
                                        <div class="flex-grow-1 pe-3">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h5 class="card-title mb-0">{{ $curso->nombre }}</h5>
                                                <span class="badge rounded-pill {{ $curso->status ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $curso->status ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </div>

                                            @if($curso->pdf)
                                                <a href="{{ asset('storage/' . $curso->pdf) }}" target="_blank" class="badge bg-info mb-2">
                                                    <i class="fas fa-file-pdf me-1"></i> Ver PDF
                                                </a>
                                            @endif

                                            <div class="d-flex justify-content-between text-muted small mb-2">
                                                <div>
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $curso->created_at->format('d/m/Y') }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Botones de acción -->
                                        <div class="d-flex flex-column justify-content-between" style="min-width: 120px;">
                                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-outline-primary mb-2">
                                                <i class="fas fa-eye me-1"></i> Ver
                                            </a>

                                            @auth
                                                @if($user->role == 'ADMIN')
                                                    <a href="{{ route('cursos.edit', $curso->id) }}"
                                                        class="btn btn-sm btn-outline-warning mb-2">
                                                        <i class="fas fa-edit me-1"></i> Editar
                                                    </a>

                                                    @if ($curso->status)
                                                        <form method="POST"
                                                            action="{{ route('cursos.destroy', $curso->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-outline-danger w-100"
                                                                onclick="return confirm('¿Desactivar este curso?')">
                                                                <i class="fas fa-toggle-off me-1"></i> Desactivar
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST"
                                                            action="{{ route('cursos.activate', $curso->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-sm btn-outline-success w-100"
                                                                onclick="return confirm('¿Activar este curso?')">
                                                                <i class="fas fa-toggle-on me-1"></i> Activar
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            @endauth
                                        </div>
                                    </div>

                                    <!-- Layout para móviles -->
                                    <div class="d-flex flex-column d-md-none">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-0">{{ $curso->nombre }}</h5>
                                            <span class="badge rounded-pill {{ $curso->status ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $curso->status ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </div>

                                        <div class="d-flex align-items-center mb-2">
                                            @if($curso->pdf)
                                                <a href="{{ asset('storage/' . $curso->pdf) }}" target="_blank" class="badge bg-info me-2">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @endif
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $curso->created_at->format('d/m/Y') }}
                                            </small>
                                        </div>

                                        <!-- Imagen en móviles -->
                                        <div class="mb-3 text-center">
                                            @if($curso->img)
                                                <img src="{{ asset('storage/' . $curso->img) }}" 
                                                    class="img-fluid rounded" 
                                                    alt="Imagen del curso"
                                                    style="max-height: 100px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary d-flex align-items-center justify-content-center rounded mx-auto"
                                                    style="width: 120px; height: 100px;">
                                                    <i class="fas fa-book fa-2x text-light"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Botones en horizontal para móviles -->
                                        <div class="d-flex gap-2 mt-2">
                                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-sm-inline"> Ver</span>
                                            </a>

                                            @auth
                                                @if($user->role == 'ADMIN')
                                                    <a href="{{ route('cursos.edit', $curso->id) }}"
                                                        class="btn btn-sm btn-outline-warning flex-grow-1">
                                                        <i class="fas fa-edit"></i>
                                                        <span class="d-none d-sm-inline"> Editar</span>
                                                    </a>

                                                    @if ($curso->status)
                                                        <form method="POST"
                                                            action="{{ route('cursos.destroy', $curso->id) }}"
                                                            class="flex-grow-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-outline-danger w-100"
                                                                onclick="return confirm('¿Desactivar este curso?')">
                                                                <i class="fas fa-toggle-off"></i>
                                                                <span class="d-none d-sm-inline"> Desactivar</span>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST"
                                                            action="{{ route('cursos.activate', $curso->id) }}"
                                                            class="flex-grow-1">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-sm btn-outline-success w-100"
                                                                onclick="return confirm('¿Activar este curso?')">
                                                                <i class="fas fa-toggle-on"></i>
                                                                <span class="d-none d-sm-inline"> Activar</span>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-3 mt-md-4">
                    {{ $cursos->links() }}
                </div>
            @endif
        </div>
    </div>
</body>