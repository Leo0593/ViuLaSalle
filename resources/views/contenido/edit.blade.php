<div class="container">
    <h2>Editar Contenido</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contenido.update', $contenido->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_vista" class="form-label">ID Vista</label>
            <input type="number" name="id_vista" id="id_vista" value="{{ old('id_vista', $contenido->id_vista) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="vista_tipo" class="form-label">Tipo Vista</label>
            <select name="vista_tipo" id="vista_tipo" class="form-select" required>
                <option value="curso" {{ old('vista_tipo', $contenido->vista_tipo) == 'curso' ? 'selected' : '' }}>Curso</option>
                <option value="evento" {{ old('vista_tipo', $contenido->vista_tipo) == 'evento' ? 'selected' : '' }}>Evento</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" name="tipo" id="tipo" value="{{ old('tipo', $contenido->tipo) }}" class="form-control" maxlength="50">
        </div>

        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" required>
            <option value="contenedor" {{ $contenido->tipo == 'contenedor' ? 'selected' : '' }}>Contenedor</option>
            <option value="columna" {{ $contenido->tipo == 'columna' ? 'selected' : '' }}>Columna</option>
        </select>
        <br>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $contenido->titulo) }}" class="form-control" maxlength="255">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $contenido->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
            @if($contenido->imagen)
                <img src="{{ asset('storage/' . $contenido->imagen) }}" alt="Imagen actual" style="max-width: 150px; margin-top:10px;">
            @endif
        </div>


        <div class="mb-3">
            <label for="video" class="form-label">Video URL</label>
            <input type="text" name="video" id="video" value="{{ old('video', $contenido->video) }}" class="form-control" maxlength="255">
        </div>

        <div class="mb-3">
            <label for="opcion" class="form-label">Opción</label>
            <input type="number" name="opcion" id="opcion" value="{{ old('opcion', $contenido->opcion) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('contenido.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

