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

        <!-- Nombre -->
        <label for="nombre">Nombre del curso:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" maxlength="255" required>
        <br><br>

        <!-- Título -->
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required>
        <br><br>

        <!-- Descripción -->
        <label for="descripcion">Descripción:</label><br>
        <textarea name="descripcion" id="descripcion" rows="5" required>{{ old('descripcion') }}</textarea>
        <br><br>

        <!-- PDF -->
        <label for="pdf">PDF del curso:</label>
        <input type="file" name="pdf" id="pdf" accept=".pdf">
        <br><br>
        
        <!-- Imagen -->
        <label for="img">Imagen del curso:</label>
        <input type="file" name="img" id="img" accept="image/*">
        <br><br> 

        <!-- Video -->
        <label for="video">Video (URL o código embebido):</label>
        <input type="text" name="video" id="video" value="{{ old('video') }}" maxlength="255">
        <br><br>


        <!-- Botón de envío -->
        <button type="submit">Guardar curso</button>
    </form>
</body>

</html>