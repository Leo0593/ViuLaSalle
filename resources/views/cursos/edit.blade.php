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
        <br><br>

        <label for="nombre">Nombre del curso:</label>
        <input type="text" name="nombre" value="{{ $curso->nombre }}" required>
        <br><br>

       <label for="img">Imagen del curso:</label>
        <input type="file" name="img" accept="image/*">
        @if($curso->img)
            <img src="{{ asset('storage/' . $curso->img) }}" alt="imagen curso" width="80" style="margin: 5px;">
        @endif
        <br><br>

        <label for="video">Video del curso:</label>
        <input type="text" name="video" value="{{ $curso->video }}" placeholder="URL del video">
        <br><br>

        <label for="pdf">PDF del curso:</label>
        <input type="file" name="pdf" accept=".pdf">
        @if($curso->pdf)
            <a href="{{ asset('storage/' . $curso->pdf) }}" target="_blank">Ver PDF</a>
        @endif
        <br><br>

        <label for="titulo">Título del curso:</label>
        <input type="text" name="titulo" value="{{ $curso->titulo }}" required>
        <br><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required>{{ $curso->descripcion }}</textarea>
        <br><br>


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
        <br><br>

        <button type="submit">Guardar cambios</button>
    </form>

</body>

</html>