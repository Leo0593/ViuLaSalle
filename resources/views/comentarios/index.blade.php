@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <h2>Comentarios de la publicación</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $publicacion->titulo }}</h4>
            <p>{{ $publicacion->contenido }}</p>
        </div>
    </div>

    <h3>Comentarios</h3>
    @foreach($publicacion->comentarios as $comentario)
        <div class="card my-2">
            <div class="card-body">
                <strong>{{ $comentario->usuario->name }}</strong> dijo:
                <p>{{ $comentario->contenido }}</p>

                <!-- Solo el propietario del comentario puede ver el botón -->
                @if($comentario->status == 1)
                    @if($comentario->id_user == auth()->id())  <!-- Verificamos que el usuario logueado sea el mismo que el que hizo el comentario -->
                        <form action="{{ route('comentarios.changeStatus', $comentario->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning btn-sm">Desactivar Comentario</button>
                        </form>
                    @endif
                @else
                    <span class="text-muted">Comentario desactivado</span>
                @endif
            </div>
        </div>
    @endforeach
</div>

<h3>Agregar un comentario</h3>
<form action="{{ route('comentarios.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id_publicacion" value="{{ $publicacion->id }}">

    <div class="mb-3">
        <label for="contenido" class="form-label">Tu comentario:</label>
        <textarea name="contenido" id="contenido" class="form-control" rows="3" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Publicar Comentario</button>
</form>
