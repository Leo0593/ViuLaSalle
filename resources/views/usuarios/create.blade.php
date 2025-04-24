@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container mt-5 mb-5" style="margin-top: 200px !important;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Tarjeta con esquinas redondeadas -->
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h1 class="h2 text-center" style="font-size: 2rem;">Crear Nuevo Usuario</h1>
                    </div>

                    <div class="card-body px-5 pb-5">
                        <!-- Mensajes de error -->
                        @if ($errors->any())
                            <div class="alert alert-danger" style="font-size: 1.05rem;">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Formulario para crear usuario -->
                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Imagen de perfil circular centrada y más grande -->
                            <div class="text-center mb-4">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 180px; height: 180px; background-color: #f0f0f0; border: 4px solid #e0e0e0;">
                                    <i class="fas fa-user-plus fa-4x text-secondary"></i>
                                </div>

                                <!-- Botón para seleccionar imagen -->
                                <div class="mt-4">
                                    <label for="avatar" class="btn btn-outline-primary rounded-pill"
                                        style="font-size: 1.1rem; padding: 0.5rem 1.5rem;">
                                        <i class="fas fa-camera me-2"></i> Seleccionar Foto
                                    </label>
                                    <input type="file" id="avatar" name="avatar" accept="image/*" class="d-none">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="name" class="form-label" style="font-size: 1.1rem;">Nombre</label>
                                <input type="text" class="form-control rounded-pill py-2" style="font-size: 1.1rem;"
                                    id="name" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label" style="font-size: 1.1rem;">Correo Electrónico</label>
                                <input type="email" class="form-control rounded-pill py-2" style="font-size: 1.1rem;"
                                    id="email" name="email" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label" style="font-size: 1.1rem;">Contraseña</label>
                                <input type="password" class="form-control rounded-pill py-2" style="font-size: 1.1rem;"
                                    id="password" name="password" required>
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label" style="font-size: 1.1rem;">Teléfono (Opcional)</label>
                                <input type="text" class="form-control rounded-pill py-2" style="font-size: 1.1rem;"
                                    id="phone" name="phone" value="{{ old('phone') }}">
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label" style="font-size: 1.1rem;">Rol</label>
                                <select class="form-control rounded-pill py-2" style="font-size: 1.1rem;" id="role"
                                    name="role" required>
                                    <option value="USER" {{ old('role') == 'USER' ? 'selected' : '' }}>Usuario</option>
                                    <option value="ADMIN" {{ old('role') == 'ADMIN' ? 'selected' : '' }}>Administrador</option>
                                    <option value="PROFESOR" {{ old('role') == 'PROFESOR' ? 'selected' : '' }}>Profesor</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <div class="col-md-6 d-flex justify-content-md-end">
                                    <a href="{{ route('users.index') }}"
                                        class="btn btn-outline-secondary rounded-pill me-md-2 px-4"
                                        style="font-size: 1.1rem;">
                                        Cancelar
                                    </a>
                                </div>
                                
                                <button type="submit" class="btn btn-primary rounded-pill px-4"
                                    style="font-size: 1.1rem;">
                                    <i class="fas fa-user-plus me-2"></i> Crear Usuario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>