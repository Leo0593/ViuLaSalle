<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Curso</title>
</head>
<body>
    <h1>Crear nuevo curso</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nivel educativo -->
        <label for="id_nivel">Nivel educativo:</label>
        <select name="id_nivel" id="id_nivel" required>
            <option value="">-- Selecciona un nivel --</option>
            @foreach($niveles as $nivel)
                <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
            @endforeach
        </select>
        <br><br>

        <!-- Nombre del curso -->
        <label for="nombre">Nombre del curso:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br><br>

        <!-- Subida de imágenes -->
        <label for="fotos">Subir imágenes:</label>
        <input type="file" name="fotos[]" id="fotos" multiple accept="image/*">
        <br><br>

        <!-- Botón de envío -->
        <button type="submit">Guardar curso</button>
    </form>
</body>
</html>
