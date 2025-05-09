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
                <select name="id_evento" id="id_evento" class="form-control">
                    <option value="0" selected>Sin evento</option> <!-- Valor por defecto -->
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

            <!-- Buscar Etiquetas -->
            <div class="form-group">
                <label for="tags">Buscar Etiquetas</label>
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
                        @foreach($categoriasSugeridas as $categoria)
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
            const allCategories = @json($categorias);
            const defaultCategories = @json($categoriasSugeridas);

            function renderCategoryButtons(categories) {
                $('#categorias-list').empty();
                categories.forEach(cat => {
                    $('#categorias-list').append(`
                    <button type="button" class="btn btn-outline-primary category-btn" data-id="${cat.id}">
                        ${cat.nombre}
                    </button>
                `);
                });
            }

            $('#tags-search').on('input', function () {
                const searchText = $(this).val().toLowerCase();

                if (searchText === '') {
                    renderCategoryButtons(defaultCategories); // Volver a mostrar sugeridas
                } else {
                    const filtered = allCategories.filter(cat => cat.nombre.toLowerCase().includes(searchText));
                    renderCategoryButtons(filtered);
                }
            });

            function updateSelectedTags() {
                const selectedTags = $('#categorias').val() || [];
                $('#selected-tags-list').empty();

                selectedTags.forEach(tagId => {
                    const tag = allCategories.find(c => c.id == tagId);
                    if (tag) {
                        $('#selected-tags-list').append(`
                        <span class="badge badge-info m-1" data-id="${tag.id}">
                            ${tag.nombre}
                            <button type="button" class="btn btn-sm btn-danger remove-tag">x</button>
                        </span>
                    `);
                    }
                });
            }

            $(document).on('click', '.category-btn', function () {
                const tagId = $(this).data('id').toString();
                const currentVal = $('#categorias').val() || [];

                if (!currentVal.includes(tagId)) {
                    currentVal.push(tagId);
                    $('#categorias').val(currentVal).trigger('change');
                }

                $('#tags-search').val('');
                updateSelectedTags();

                // Verificar si la categoría seleccionada NO está en las sugeridas
                const isInSugeridas = defaultCategories.some(cat => cat.id.toString() === tagId);
                if (!isInSugeridas) {
                    // Volver a mostrar las sugeridas originales
                    renderCategoryButtons(defaultCategories);
                }
            });

            $(document).on('click', '.remove-tag', function () {
                const tagId = $(this).parent().data('id').toString();
                let currentVal = $('#categorias').val() || [];

                currentVal = currentVal.filter(id => id !== tagId);
                $('#categorias').val(currentVal).trigger('change');
                updateSelectedTags();
            });

            // Cargar etiquetas seleccionadas al inicio
            updateSelectedTags();
        });
    </script>


</body>

</html>