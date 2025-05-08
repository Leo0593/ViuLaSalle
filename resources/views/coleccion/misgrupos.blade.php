<div>
    @foreach ($grupos as $grupo)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $grupo->nombre }}</h5>
                <p class="card-text">Descripción: {{ $grupo->descripcion }}</p>
                <p class="card-text">Fecha de creación: {{ $grupo->created_at->format('d/m/Y') }}</p>
                <p class="card-text">Número de miembros: {{ $grupo->miembros_count }}</p>
                <p class="card-text">Estado: {{ $grupo->estado }}</p>
                <a href="{{ route('coleccion.grupo', $grupo->id) }}" class="btn btn-primary">Ver grupo</a>
                <a href="{{ route('coleccion.grupo.editar', $grupo->id) }}" class="btn btn-secondary">Editar grupo</a>
            </div>
        </div>
    @endforeach
</div>