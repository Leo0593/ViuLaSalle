@include('layouts.head')

<body>

    @include('layouts.navheader')

    <!-- Hero o Bienvenida -->
    <div class="container py-4">



        <div class="body-container hero-section p-4 mb-4 rounded-4 shadow-sm"
            style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);">
            <div class="container text-center">
                <h1 class="display-5 fw-bold text-dark mb-3">Gestión de Usuarios</h1>
                <p class="lead text-muted mb-4">Aquí puedes ver, crear y editar usuarios registrados en el sistema.
                </p>
            </div>
        </div>

        <!-- Botones de acción -->

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 p-3 bg-white rounded-3 shadow-sm">
            <h2 class="mb-3 mb-md-0 fw-semibold">Listado de Usuarios</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('users.create') }}" class="btn btn-primary create-btn">
                    <i class="fas fa-plus me-2"></i>Crear Usuario
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Dashboard
                </a>
            </div>
        </div>




        <!-- Contadores de usuarios -->
        <div class="bg-light p-4 rounded-4 mb-4 shadow-sm">

            <div class="row text-center mb-4">
                <div class="col-md-2 offset-md-1">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h5 class="card-title">Admins</h5>
                            <p class="card-text fs-4 text-primary">{{ $countAdmin }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-success">
                        <div class="card-body">
                            <h5 class="card-title">Usuarios</h5>
                            <p class="card-text fs-4 text-success">{{ $countUser }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-warning">
                        <div class="card-body">
                            <h5 class="card-title">Profesores</h5>
                            <p class="card-text fs-4 text-warning">{{ $countProfesor }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-info">
                        <div class="card-body">
                            <h5 class="card-title">Activos</h5>
                            <p class="card-text fs-4 text-info">{{ $countActivos }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-danger">
                        <div class="card-body">
                            <h5 class="card-title">Inactivos</h5>
                            <p class="card-text fs-4 text-danger">{{ $countInactivos }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Buscador y filtros -->
        <div class="bg-white p-4 rounded-3 mb-4 shadow-sm border border-light">
            <form action="{{ route('users.index') }}" method="GET" class="row g-3 align-items-end">
                <!-- Título de la sección -->
                <!-- Título -->
                <div class="col-12 mb-2">
                    <h5 class="text-primary mb-0">
                        <i class="fas fa-sliders-h me-2"></i>Filtrar Usuarios
                    </h5>
                    <hr class="mt-2 mb-3">
                </div>

                <!-- Buscar por nombre o email -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" name="search" id="search" class="form-control shadow-sm"
                            placeholder="Nombre o email" value="{{ request('search') }}">
                        <label for="search" class="form-label">Nombre o email</label>
                    </div>
                </div>

                <!-- Filtrar por Rol -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <select name="role" id="role" class="form-select shadow-sm">
                            <option value="">Todos</option>
                            <option value="ADMIN" {{ request('role') == 'ADMIN' ? 'selected' : '' }}>Administrador
                            </option>
                            <option value="USER" {{ request('role') == 'USER' ? 'selected' : '' }}>Usuario</option>
                            <option value="PROFESOR" {{ request('role') == 'PROFESOR' ? 'selected' : '' }}>Profesor
                            </option>
                        </select>
                        <label for="role" class="form-label">Rol</label>
                    </div>
                </div>

                <!-- Filtrar por Estado -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <select name="status" id="status" class="form-select shadow-sm">
                            <option value="">Todos</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        <label for="status" class="form-label">Estado</label>
                    </div>
                </div>

                <!-- Botones -->
                <div class="col-md-3 d-flex gap-2 align-self-end">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-broom me-1"></i> Limpiar
                    </a>
                    <button type="submit" class="btn btn-primary w-100 shadow">
                        <i class="fas fa-filter me-1"></i> Aplicar
                    </button>
                </div>

            </form>
        </div>



        <!-- Lista de usuarios en tarjetas -->
        <div class="bg-light p-4 rounded-4 mb-4 shadow-sm">

            <div class="row">
                @foreach ($users as $user)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" class="card-img-top" alt="Avatar"
                                    style="height: 250px; object-fit: cover; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center"
                                    style="height: 250px; background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                                    <span class="text-muted fs-5">Sin foto de perfil</span>
                                </div>
                            @endif

                            <div class="card-body p-4">
                                <h5 class="card-title mb-3 text-center" style="font-size: 1.5rem; font-weight: 600;">
                                    {{ $user->name }}
                                </h5>
                                <div class="card-text" style="font-size: 1.1rem;">
                                    <div class="mb-3">
                                        <strong class="d-block" style="font-size: 1rem;">Email</strong>
                                        <span class="text-muted">{{ $user->email }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="d-block" style="font-size: 1rem;">Teléfono</strong>
                                        <span class="text-muted">{{ $user->phone ?? 'No disponible' }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="d-block" style="font-size: 1rem;">Rol</strong>
                                        <span class="text-muted">{{ $user->role }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="d-block" style="font-size: 1rem;">Estado</strong>
                                        @if($user->status)
                                            <span class="badge bg-success rounded-pill px-3 py-1"
                                                style="font-size: 0.9rem;">Activo</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3 py-1"
                                                style="font-size: 0.9rem;">Inactivo</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-0 d-flex justify-content-between p-4 pt-0">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary px-4 py-2"
                                    style="border-radius: 50px; font-size: 1rem;">
                                    <i class="fa fa-edit me-2"></i> Editar
                                </a>

                                <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning px-4 py-2"
                                        style="border-radius: 50px; font-size: 1rem;">
                                        <i class="fa fa-power-off me-2"></i> {{ $user->status ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>

    </div>

</body>

</html>