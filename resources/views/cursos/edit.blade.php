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