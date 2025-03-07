<div class="container">
    <h1>Editar Evento</h1>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Evento</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $evento->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion', $evento->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Imagen del Evento</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            @if ($evento->foto)
                <p class="mt-2">Imagen actual:</p>
                <img src="{{ asset('storage/' . $evento->foto) }}" alt="Imagen del evento" class="img-thumbnail" width="200">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Evento</button>
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>