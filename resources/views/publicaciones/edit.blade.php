<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    <div class="container">
        <form action="{{ route('publicaciones.update', $publicacion->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="id_user" class="form-label">Usuario</label>
                <select name="id_user" class="form-control">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ $usuario->id == $publicacion->id_user ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_evento" class="form-label">Evento</label>
                <select name="id_evento" class="form-control">
                    @foreach($eventos as $evento)
                        <option value="{{ $evento->id }}" {{ $evento->id == $publicacion->id_evento ? 'selected' : '' }}>
                            {{ $evento->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required>{{ $publicacion->descripcion }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Fotos Actuales</label>
                <div>
                    @foreach($publicacion->fotos as $foto)
                        <div class="d-inline-block me-2">
                            <img src="{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}" width="100" class="me-2">
                            <div>
                                <input type="checkbox" name="delete_photos[]" value="{{ $foto->id }}"> Eliminar
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="fotos" class="form-label">Nuevas Fotos (Opcional)</label>
                <input type="file" name="fotos[]" class="form-control" multiple>
            </div>

            @if ($user && ($user->role == 'PROFESOR' || $user->role == 'ADMIN'))
                <div class="mb-3">
                    <label class="form-label">Videos Actuales</label>
                    <div>
                        @foreach($publicacion->videos as $video)
                            <div class="d-inline-block me-2">
                                <video width="100" controls>
                                    <source src="{{ asset('storage/publicvideos/' . $video->ruta_video) }}" type="video/mp4">
                                    Tu navegador no soporta la reproducción de videos.
                                </video>
                                <div>
                                    <input type="checkbox" name="delete_videos[]" value="{{ $video->id }}"> Eliminar
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label for="videos" class="form-label">Nuevos Videos (Opcional)</label>
                    <input type="file" name="videos[]" class="form-control" multiple accept="video/*">
                </div>
            @endif

            <!-- Categorías -->
            <div class="form-group mt-2">
                <label for="tags-search">Buscar Etiquetas</label>
                <input type="text" id="tags-search" class="form-control" placeholder="Buscar etiquetas...">

                <div class="form-group mt-2">
                    <!-- Input oculto para enviar las categorías seleccionadas -->
                    <select name="categorias[]" id="categorias" class="form-control" multiple style="display: none;">
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" class="tag-option" @if(in_array($categoria->id, $publicacion->categorias->pluck('id')->toArray())) selected @endif>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Mostrar las categorías sugeridas como botones -->
                    <div id="categorias-list" class="mt-2">
                        @foreach($categorias as $categoria)
                            <button type="button" class="btn btn-outline-primary category-btn"
                                data-id="{{ $categoria->id }}">
                                {{ $categoria->nombre }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Mostrar las etiquetas seleccionadas -->
                <div id="selected-tags" class="mt-3">
                    <strong>Etiquetas seleccionadas:</strong>
                    <div id="selected-tags-list">
                        @foreach($publicacion->categorias as $categoria)
                            <span class="badge badge-info m-1" data-id="{{ $categoria->id }}">
                                {{ $categoria->nombre }}
                                <button type="button" class="btn btn-sm btn-danger remove-tag">x</button>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="form-group form-check">
                <input type="checkbox" name="activar_comentarios" id="activar_comentarios" class="form-check-input"
                    value="1" {{ $publicacion->activar_comentarios ? 'checked' : '' }}>
                <label class="form-check-label" for="activar_comentarios">Permitir comentarios</label>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>

   <script>
        $(document).ready(function () {
            // Filtrar las opciones de categorías a medida que el usuario escribe
            $('#tags-search').on('input', function () {
                var searchText = $(this).val().toLowerCase();
                $('.category-btn').each(function () {
                    var tagText = $(this).text().toLowerCase();
                    if (tagText.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Función para actualizar las etiquetas seleccionadas en el UI
            function updateSelectedTags() {
                var selectedTags = $('#categorias').val(); // Obtener los valores seleccionados
                $('#selected-tags-list').empty(); // Limpiar lista de etiquetas

                if (selectedTags) {
                    selectedTags.forEach(function (tagId) {
                        var tagText = $('button[data-id="' + tagId + '"]').text(); // Obtener el nombre de la etiqueta
                        var tagItem = '<span class="badge badge-info m-1" data-id="' + tagId + '">' + tagText +
                            ' <button type="button" class="btn btn-sm btn-danger remove-tag">x</button></span>';
                        $('#selected-tags-list').append(tagItem);
                    });
                }
            }

            // Agregar categoría seleccionada cuando el usuario hace clic en un botón de categoría
            $(document).on('click', '.category-btn', function () {
                var tagId = $(this).data('id');
                var tagText = $(this).text();

                // Añadir la categoría seleccionada al campo oculto
                var currentVal = $('#categorias').val() || [];
                if (!currentVal.includes(tagId.toString())) {
                    currentVal.push(tagId.toString());
                    $('#categorias').val(currentVal).trigger('change');
                }

                // Limpiar el campo de búsqueda
                $('#tags-search').val('');

                // Actualizar la lista de etiquetas seleccionadas
                updateSelectedTags();
            });

            // Eliminar etiqueta cuando se hace clic en el botón de eliminar
            $(document).on('click', '.remove-tag', function () {
                var tagId = $(this).parent().data('id');
                var currentVal = $('#categorias').val() || [];
                currentVal = currentVal.filter(function (id) { return id != tagId; });
                $('#categorias').val(currentVal).trigger('change');

                // Actualizar la lista de etiquetas seleccionadas
                updateSelectedTags();
            });

            // Inicializar las etiquetas seleccionadas al cargar la página
            updateSelectedTags();
        });
    </script>


</body>

</html>