@include('layouts.head')

<body>

    @include('layouts.navheader')

    <!-- Hero o Bienvenida -->
    <div class="container mt-5 pt-5">

        <div class="container mt-4 pt-4"> </div>

        <div class="bg-light p-4 rounded-4 mb-4 shadow-sm">

            <div class="text-center my-5">
                <h1 class="display-5 fw-bold">Gestión de Usuarios</h1>
                <p class="lead text-muted">Aquí puedes ver, crear y editar usuarios registrados en el sistema.</p>
            </div>

            <!-- Botones de acción -->
            <div class="d-flex justify-content-center gap-3 mb-4">
                <div class="col-md-2">
                    <a href="{{ route('users.create') }}" class="btn btn-success">
                        <i class="fa fa-user-plus me-1"></i> Crear Usuario
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Volver a Dashboard
                    </a>
                </div>


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
        <div class="bg-light p-4 rounded-4 mb-4 shadow-sm">

            <form action="{{ route('users.index') }}" method="GET" class="row mb-4 g-3 align-items-end">
                <!-- Campo de búsqueda -->
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nombre o email..."
                            value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Filtro por Rol -->
                <div class="col-md-3">
                    <label for="role" class="form-label">Rol</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user-tag"></i></span>
                        <select name="role" class="form-select">
                            <option value="">Todos</option>
                            <option value="ADMIN" {{ request('role') == 'ADMIN' ? 'selected' : '' }}>Administrador
                            </option>
                            <option value="USER" {{ request('role') == 'USER' ? 'selected' : '' }}>Usuario</option>
                            <option value="PROFESOR" {{ request('role') == 'PROFESOR' ? 'selected' : '' }}>Profesor
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Filtro por Estado -->
                <div class="col-md-2" style="min-width: 250px" >
                    <label for="status" class="form-label">Estado</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-circle-check"></i></span>
                        <select name="status" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <!-- Botón -->
                <div >
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-filter me-1"></i> Filtrar
                    </button>
                     <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fa fa-times me-1"></i> Limpiar
                    </a>
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
        </div>

    </div>

</body>

</html>