<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <h1 class="mb-4">Crear Nivel Educativo </h1>
        <form action="{{ route('niveles.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <button type="submit" class="btn btn-primary">Crear Categoria</button>
        </form>
    </div>
</body>

</html>