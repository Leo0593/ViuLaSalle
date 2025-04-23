<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Editar curso</h1>

    <form action="{{ route('cursos.update', $curso->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="id_nivel">Nivel educativo:</label>
        <select name="id_nivel" required>
            @foreach($niveles as $nivel)
                <option value="{{ $nivel->id }}" {{ $curso->id_nivel == $nivel->id ? 'selected' : '' }}>
                    {{ $nivel->nombre }}
                </option>
            @endforeach
        </select>

        <label for="nombre">Nombre del curso:</label>
        <input type="text" name="nombre" value="{{ $curso->nombre }}" required>

        <!-- Duración -->
        <label for="duracion">Duración:</label>
        <input type="text" name="duracion" id="duracion" value="{{ $curso->duracion }}">
        <br><br>

        <!-- Posibilidades de continuidad -->
        <label for="posibilidades_continuidad">Posibilidades de continuidad:</label>
        <textarea name="posibilidades_continuidad" id="posibilidades_continuidad"
            rows="3">{{ $curso->posibilidades_continuidad }}</textarea>
        <br><br>

        <!-- Sector profesional -->
        <label for="sector_profesional">Sector profesional:</label>
        <input type="text" name="sector_profesional" id="sector_profesional" value="{{ $curso->sector_profesional }}">
        <br><br>

        <!-- Salidas profesionales -->
        <label for="salidas_profesionales">Salidas profesionales:</label>
        <textarea name="salidas_profesionales" id="salidas_profesionales"
            rows="3">{{ $curso->salidas_profesionales }}</textarea>
        <br><br>

        <!-- PDF actual -->
        @if($curso->asignaturas_pdf)
            <h3>Asignaturas Principales (PDF actual):</h3>
            <div>
                <a href="{{ asset('storage/' . $curso->asignaturas_pdf) }}" target="_blank">Ver PDF actual</a><br>
                <label>
                    <input type="checkbox" name="delete_pdf" value="1"> Eliminar PDF
                </label>
            </div>
        @endif

        <!-- Subir nuevo PDF -->
        <h3>Subir nuevo PDF de asignaturas:</h3>
        <input type="file" name="asignaturas_pdf" accept="application/pdf">

        <h3>Fotos actuales:</h3>
        @foreach($curso->fotos as $foto)
            <div>
                <img src="{{ asset('storage/' . $foto->ruta_imagen) }}" alt="foto" width="100">
                <label>
                    <input type="checkbox" name="delete_fotos[]" value="{{ $foto->id }}">
                    Eliminar
                </label>
            </div>
        @endforeach

        <h3>Agregar nuevas fotos:</h3>
        <input type="file" name="fotos[]" multiple>

        <button type="submit">Guardar cambios</button>
    </form>

</body>

</html>