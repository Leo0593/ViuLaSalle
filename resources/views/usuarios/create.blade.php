<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Crear Usuario</h1>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>


            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono (Opcional)</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="USER" {{ old('role') == 'USER' ? 'selected' : '' }}>Usuario</option>
                    <option value="ADMIN" {{ old('role') == 'ADMIN' ? 'selected' : '' }}>Administrador</option>
                    <option value="PROFESOR" {{ old('role') == 'PROFESOR' ? 'selected' : '' }}>Profesor</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Foto de Perfil (Opcional)</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Crear Usuario</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>