<!-- resources/views/publicaciones/create.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Publicación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Mostrar la alerta si hay un mensaje de error en la sesión -->
    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    <div class="container mt-5">
        <h1>Crear Publicación</h1>
        <a href="{{ route('publicaciones.index') }}" class="btn btn-secondary mb-3">Volver</a>

        <form action="{{ route('publicaciones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">


            <div class="form-group">
                <label for="id_evento">Evento</label>
                <select name="id_evento" id="id_evento" class="form-control" required>
                    <option value="" selected disabled>Selecciona un evento</option> <!-- Opción inicial -->
                    @foreach($eventos as $evento)
                        <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="fotos">Fotos</label>
                <input type="file" name="fotos[]" id="fotos" class="form-control" multiple>
            </div>

            @if ($user && ($user->role == 'PROFESOR' || $user->role == 'ADMIN'))
                <div class="form-group">
                    <label for="videos">Videos</label>
                    <input type="file" name="videos[]" id="videos" class="form-control" multiple>
                </div>
            @endif

            <div class="form-group">
                <label for="tags">Buscar Etiquetas</label>
                <!-- Input de búsqueda para las etiquetas -->
                <input type="text" id="tags-search" class="form-control" placeholder="Buscar etiquetas...">

                <div class="form-group mt-2">
                    
                    <!-- Input oculto para enviar las categorías seleccionadas -->
                    <select name="categorias[]" id="categorias" class="form-control" multiple style="display: none;">
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" class="tag-option">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>

                    <!-- Mostrar las 5 categorías aleatorias sugeridas como botones -->
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
                        <!-- Aquí se mostrarán las etiquetas seleccionadas -->
                    </div>
                </div>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" name="activar_comentarios" id="activar_comentarios" class="form-check-input"
                    value="1">
                <label class="form-check-label" for="activar_comentarios">Permitir comentarios</label>
            </div>



            <button type="submit" class="btn btn-primary">Guardar Publicación</button>
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