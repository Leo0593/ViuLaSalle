<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Verificación en 2 pasos</h1>

    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('verificacion.validar') }}" method="POST">
        @csrf
        <label for="codigo">Ingresa el código que recibiste:</label>
        <input type="text" name="codigo" required>
        <button type="submit">Verificar</button>
    </form>

</body>

</html>