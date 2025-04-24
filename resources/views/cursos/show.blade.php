<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Curso</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #333; }
        .campo { margin-bottom: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>

    <h1>Detalles del curso: {{ $curso->nombre }}</h1>

    <div class="campo"><span class="label">Nivel educativo:</span> {{ $curso->nivelEducativo->nombre }}</div>
    <div class="campo"><span class="label">Duración:</span> {{ $curso->duracion ?? 'No especificada' }}</div>
    <div class="campo"><span class="label">Posibilidades de continuidad:</span><br> {{ $curso->posibilidades_continuidad ?? 'No especificadas' }}</div>
    <div class="campo"><span class="label">Sector profesional:</span> {{ $curso->sector_profesional ?? 'No especificado' }}</div>
    <div class="campo"><span class="label">Salidas profesionales:</span><br> {{ $curso->salidas_profesionales ?? 'No especificadas' }}</div>
    <div class="campo"><span class="label">Prácticas en empresas:</span> {{ $curso->practicas_en_empresas ? 'Sí' : 'No' }}</div>

    @if ($curso->asignaturas_pdf)
        <div class="campo">
            <span class="label">Asignaturas principales:</span>
            <a href="{{ asset('storage/' . $curso->asignaturas_pdf) }}" target="_blank">Ver PDF</a>
        </div>
    @endif

    <div class="campo">
        <span class="label">Imágenes:</span><br>
        @forelse($curso->fotos as $foto)
            <img src="{{ asset('storage/' . $foto->ruta_imagen) }}" alt="Imagen del curso" width="150" style="margin: 10px;">
        @empty
            <p>No hay imágenes disponibles.</p>
        @endforelse
    </div>

    <a href="{{ route('niveles.index') }}">← Volver al listado de cursos</a>

</body>
</html>
