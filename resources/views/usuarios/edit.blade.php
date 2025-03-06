<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Usuario</h1>

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

        <!-- Formulario para editar usuario -->
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono (Opcional)</label>
                <input type="text" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', $user->phone) }}">
            </div>
            
            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="USER" {{ old('role', $user->role) == 'USER' ? 'selected' : '' }}>Usuario</option>
                    <option value="ADMIN" {{ old('role', $user->role) == 'ADMIN' ? 'selected' : '' }}>Administrador
                    </option>
                    <option value="PROFESOR" {{ old('role', $user->role) == 'PROFESOR' ? 'selected' : '' }}>Profesor
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Foto de Perfil (Opcional)</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                @if($user->avatar)
                    <div class="mt-2">
                        <p>Imagen actual:</p>
                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" width="50" height="50">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>