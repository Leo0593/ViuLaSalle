<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Publicación de Colección</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        label {
            font-weight: bold;
        }
        button {
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Crear Publicación de Colección</h1>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('publicacioncolecciones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <input type="hidden" name="coleccion_id" value="{{ $coleccion_id }}">

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>

            <label for="fotos">Subir Fotos</label>
            <input type="file" name="fotos[]" id="fotos" accept="image/*" multiple>

            <button type="submit">Crear Publicación</button>
        </form>
    </div>
</body>
</html>
