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

        <!-- Duración -->
        <label for="duracion">Duración:</label>
        <input type="text" name="duracion" id="duracion" placeholder="Ej: 2 años">
        <br><br>

        <!-- Posibilidades de continuidad -->
        <label for="posibilidades_continuidad">Posibilidades de continuidad:</label>
        <textarea name="posibilidades_continuidad" id="posibilidades_continuidad" rows="4" cols="50"
            placeholder="Describe las posibilidades"></textarea>
        <br><br>

        <!-- Sector Profesional -->
        <label for="sector_profesional">Sector profesional:</label>
        <input type="text" name="sector_profesional" id="sector_profesional">
        <br><br>

        <!-- Salidas Profesionales -->
        <label for="salidas_profesionales">Salidas profesionales:</label>
        <textarea name="salidas_profesionales" id="salidas_profesionales" rows="4" cols="50"></textarea>
        <br><br>

        <!-- Asignaturas (PDF) -->
        <label for="asignaturas_pdf">Asignaturas principales (PDF):</label>
        <input type="file" name="asignaturas_pdf" id="asignaturas_pdf" accept="application/pdf">
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