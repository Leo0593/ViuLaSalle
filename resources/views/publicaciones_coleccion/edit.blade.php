<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicación</title>
    <style>
        /* Estilos para el formulario */
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .formulario {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .formulario input,
        .formulario textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .formulario button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .formulario button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>Editar Publicación</h1>
    
    <form method="POST" action="{{ route('publicacioncolecciones.update', $publicacion->id) }}" enctype="multipart/form-data" class="formulario">
        @csrf
        @method('PUT')

        <div>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="4">{{ old('descripcion', $publicacion->descripcion) }}</textarea>
        </div>

        <div>
            <label for="fotos">Fotos (opcional):</label>
            <input type="file" name="fotos[]" multiple accept="image/*">
        </div>

        <div>
            <button type="submit">Actualizar Publicación</button>
        </div>
    </form>

</body>

</html>
