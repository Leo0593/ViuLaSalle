@include('layouts.head')

<body class="bg-light">
    @include('layouts.navheader')

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-auto mt-3"
            style="max-width: 800px; border-left: 4px solid #dc3545;">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container py-4 margin-top-header" style="">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <!-- Header con foto de perfil -->
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex align-items-center">
                    <div class="avatar-post me-3">
                        @if(Auth::check() && Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" class="rounded-circle" alt="Avatar"
                                onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                        @else
                            <img src="{{ asset('img/user-icon.png') }}" class="rounded-circle" alt="Avatar por defecto">
                        @endif
                    </div>
                    <div>
                        <h5 class="mb-0 text-dark fw-bold">{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</h5>
                        <small class="text-muted">Editando publicación</small>
                    </div>
                </div>
            </div>

            <!-- Cuerpo del formulario -->
            <div class="card-body p-4">
                <form action="{{ route('publicaciones.update', $publicacion->id) }}" method="POST"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_user" value="{{ Auth::id() }}">

                    <!-- Sección Evento -->
                    <div class="mb-4">
                        <label for="evento-search" class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Asociar a Evento
                        </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="evento-search" class="form-control border-start-0 shadow-none"
                                placeholder="Buscar eventos..."
                                value="{{ $publicacion->evento ? $publicacion->evento->nombre : '' }}">
                        </div>

                        <!-- Input oculto para el evento seleccionado -->
                        <select name="id_evento" id="id_evento" class="form-control" style="display: none;">
                            <option value="0" {{ !$publicacion->id_evento ? 'selected' : '' }}>Sin evento</option>
                            @foreach($eventos as $evento)
                                <option value="{{ $evento->id }}" {{ $publicacion->id_evento == $evento->id ? 'selected' : '' }}>
                                    {{ $evento->nombre }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Eventos sugeridos -->
                        <div id="eventos-list" class="d-flex flex-wrap gap-2 mb-2">
                            @foreach($eventos->take(5) as $evento)
                                <button type="button" class="btn btn-outline-primary evento-btn rounded-pill px-3"
                                    data-id="{{ $evento->id }}" {{ $publicacion->id_evento == $evento->id ? 'style="display:none"' : '' }}>
                                    {{ $evento->nombre }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Evento seleccionado -->
                        <div id="evento-seleccionado" class="mt-2" {{ !$publicacion->id_evento ? 'style="display:none;"' : '' }}>
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-2">Evento seleccionado:</span>
                                <span id="evento-nombre"
                                    class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                    @if($publicacion->evento)
                                        {{ $publicacion->evento->nombre }}
                                    @endif
                                </span>
                                <button type="button" id="remove-evento"
                                    class="btn-close btn-close-white btn-sm ms-2"></button>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-edit me-2 text-primary"></i>Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion" class="form-control shadow-sm" rows="4"
                            placeholder="¿Qué quieres compartir hoy?"
                            required>{{ $publicacion->descripcion }}</textarea>
                        <div class="invalid-feedback">Por favor escribe una descripción</div>
                    </div>

                    <!-- Etiquetas -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-tags me-2 text-primary"></i>Etiquetas
                        </label>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="tags-search" class="form-control border-start-0 shadow-none"
                                placeholder="Buscar etiquetas...">
                        </div>

                        <!-- Etiquetas sugeridas -->
                        <div id="categorias-list" class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($categoriasSugeridas as $categoria)
                                <button type="button" class="btn btn-outline-primary category-btn rounded-pill px-3"
                                    data-id="{{ $categoria->id }}" {{ in_array($categoria->id, $publicacion->categorias->pluck('id')->toArray()) ? 'style="display:none"' : '' }}>
                                    {{ $categoria->nombre }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Input oculto para categorías seleccionadas -->
                        <select name="categorias[]" id="categorias" class="form-control" multiple
                            style="display: none;">
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ in_array($categoria->id, $publicacion->categorias->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Etiquetas seleccionadas -->
                        <div id="selected-tags" class="mt-3">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <span class="text-muted">Seleccionadas:</span>
                                <div id="selected-tags-list" class="d-flex flex-wrap gap-2">
                                    @foreach($publicacion->categorias as $categoria)
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill p-2"
                                            data-id="{{ $categoria->id }}">
                                            {{ $categoria->nombre }}
                                            <button type="button"
                                                class="btn-close btn-close-white btn-sm ms-2 remove-tag"></button>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Multimedia - Fotos -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-images me-2 text-primary"></i>Multimedia
                        </label>

                        <!-- Fotos actuales -->
                        <div class="mb-3">
                            <label class="form-label">Fotos Actuales</label>
                            <div class="d-flex flex-wrap gap-3" id="current-photos-container">
                                @foreach($publicacion->fotos as $foto)
                                    <div class="preview-wrapper position-relative">
                                        <img src="{{ Storage::url('publicaciones/' . $foto->ruta_foto) }}"
                                            class="preview-image">
                                        <div class="position-absolute bottom-0 start-0 p-2 bg-dark bg-opacity-50 w-100">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="delete_photos[]"
                                                    value="{{ $foto->id }}" id="delete-photo-{{ $foto->id }}">
                                                <label class="form-check-label text-white"
                                                    for="delete-photo-{{ $foto->id }}">Eliminar</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Nuevas fotos -->
                        <div class="mb-3">
                            <label for="fotos" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                <i class="fas fa-camera me-2"></i> Añadir más Fotos
                                <input type="file" name="fotos[]" id="fotos" class="d-none" multiple accept="image/*">
                            </label>
                            <small class="text-muted ms-2">Máx. 10 fotos en total</small>

                            <!-- Previsualización nuevas fotos -->
                            <div class="d-flex flex-wrap gap-3 mt-3" id="preview-container"></div>
                        </div>

                        <!-- Videos (solo para profesores/admin) -->
                        @if ($user && ($user->role == 'PROFESOR' || $user->role == 'ADMIN'))
                            <!-- Videos actuales -->
                            <div class="mb-3">
                                <label class="form-label">Videos Actuales</label>
                                <div class="d-flex flex-wrap gap-3" id="current-videos-container">
                                    @foreach($publicacion->videos as $video)
                                        <div class="preview-wrapper position-relative" style="width: 200px; height: auto;">
                                            <video controls class="w-100">
                                                <source src="{{ Storage::url('publicvideos/' . $video->ruta_video) }}"
                                                    type="video/mp4">
                                            </video>
                                            <div class="position-absolute bottom-0 start-0 p-2 bg-dark bg-opacity-50 w-100">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="delete_videos[]"
                                                        value="{{ $video->id }}" id="delete-video-{{ $video->id }}">
                                                    <label class="form-check-label text-white"
                                                        for="delete-video-{{ $video->id }}">Eliminar</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Nuevos videos -->
                            <div class="mb-3">
                                <label for="videos" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                    <i class="fas fa-video me-2"></i> Añadir más Videos
                                    <input type="file" name="videos[]" id="videos" class="d-none" multiple accept="video/*">
                                </label>
                                <small class="text-muted ms-2">Máx. 2 videos en total</small>

                                <!-- Previsualización nuevos videos -->
                                <div class="d-flex flex-wrap gap-3 mt-3" id="video-preview-container"></div>
                            </div>
                        @endif
                    </div>

                    <!-- Configuración -->
                    <div class="mb-4">
                        <div class="form-check form-switch ps-0">
                            <input class="form-check-input ms-0 me-2" type="checkbox" role="switch"
                                name="activar_comentarios" id="activar_comentarios" value="1" {{ $publicacion->activar_comentarios ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="activar_comentarios">
                                <i class="fas fa-comments me-2 text-primary"></i> Permitir comentarios
                            </label>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('publicaciones.index') }}"
                            class="btn btn-outline-secondary rounded-pill px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script>
        $(document).ready(function () {
            // Validación de formulario
            (function () {
                'use strict'
                const forms = document.querySelectorAll('.needs-validation')

                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })()

            const allCategories = @json($categorias);
            const defaultCategories = @json($categoriasSugeridas);
            const allEventos = @json($eventos);
            const sugeridos = allEventos.slice(0, 5);

            // Función para renderizar botones de categorías
            function renderCategoryButtons(categories) {
                $('#categorias-list').empty();
                categories.forEach(cat => {
                    // Solo mostrar si no está ya seleccionada
                    if (!$('#categorias').val() || !$('#categorias').val().includes(cat.id.toString())) {
                        $('#categorias-list').append(`
                            <button type="button" class="btn btn-outline-primary category-btn rounded-pill px-3" data-id="${cat.id}">
                                ${cat.nombre}
                            </button>
                        `);
                    }
                });
            }

            // Función para renderizar botones de eventos
            function renderEventoButtons(eventos) {
                $('#eventos-list').empty();
                eventos.forEach(evt => {
                    // Solo mostrar si no es el evento actualmente seleccionado
                    if ($('#id_evento').val() !== evt.id.toString()) {
                        $('#eventos-list').append(`
                            <button type="button" class="btn btn-outline-primary evento-btn rounded-pill px-3" data-id="${evt.id}">
                                ${evt.nombre}
                            </button>
                        `);
                    }
                });
            }

            // Búsqueda de etiquetas
            $('#tags-search').on('input', function () {
                const searchText = $(this).val().toLowerCase();
                if (searchText === '') {
                    renderCategoryButtons(defaultCategories);
                } else {
                    const filtered = allCategories.filter(cat =>
                        cat.nombre.toLowerCase().includes(searchText) &&
                        (!$('#categorias').val() || !$('#categorias').val().includes(cat.id.toString()))
                    );
                    renderCategoryButtons(filtered);
                }
            });

            // Búsqueda de eventos
            $('#evento-search').on('input', function () {
                const searchText = $(this).val().toLowerCase();
                if (searchText === '') {
                    renderEventoButtons(sugeridos);
                } else {
                    const filtrados = allEventos.filter(evt =>
                        evt.nombre.toLowerCase().includes(searchText) &&
                        evt.id.toString() !== $('#id_evento').val()
                    );
                    renderEventoButtons(filtrados);
                }
            });

            // Actualizar etiquetas seleccionadas
            function updateSelectedTags() {
                const selectedTags = $('#categorias').val() || [];
                $('#selected-tags-list').empty();

                selectedTags.forEach(tagId => {
                    const tag = allCategories.find(c => c.id == tagId);
                    if (tag) {
                        $('#selected-tags-list').append(`
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill p-2" data-id="${tag.id}">
                                ${tag.nombre}
                                <button type="button" class="btn-close btn-close-white btn-sm ms-2 remove-tag"></button>
                            </span>
                        `);
                    }
                });
            }

            // Seleccionar categoría
            $(document).on('click', '.category-btn', function () {
                const tagId = $(this).data('id').toString();
                const currentVal = $('#categorias').val() || [];

                if (!currentVal.includes(tagId)) {
                    currentVal.push(tagId);
                    $('#categorias').val(currentVal).trigger('change');
                }

                $('#tags-search').val('');
                updateSelectedTags();
                renderCategoryButtons(defaultCategories);
            });

            // Seleccionar evento
            $(document).on('click', '.evento-btn', function () {
                const eventoId = $(this).data('id').toString();
                const evento = allEventos.find(e => e.id == eventoId);

                if (evento) {
                    $('#id_evento').val(eventoId);
                    $('#evento-nombre').text(evento.nombre);
                    $('#evento-seleccionado').show();
                    $('#evento-search').val(evento.nombre);
                }

                renderEventoButtons(sugeridos);
            });

            // Eliminar evento seleccionado
            $('#remove-evento').on('click', function () {
                $('#id_evento').val('0');
                $('#evento-seleccionado').hide();
                $('#evento-search').val('');
                renderEventoButtons(sugeridos);
            });

            // Eliminar etiqueta
            $(document).on('click', '.remove-tag', function () {
                const tagId = $(this).parent().data('id').toString();
                let currentVal = $('#categorias').val() || [];

                currentVal = currentVal.filter(id => id !== tagId);
                $('#categorias').val(currentVal).trigger('change');
                updateSelectedTags();
                renderCategoryButtons(defaultCategories);
            });

            // Inicializar
            updateSelectedTags();
            renderEventoButtons(sugeridos);
        });

        // Previsualización de nuevas imágenes
        let selectedFiles = [];
        document.getElementById('fotos').addEventListener('change', function (e) {
            const newFiles = Array.from(this.files);

            // Verificar límite de fotos (10 en total)
            const currentPhotosCount = document.querySelectorAll('#current-photos-container .preview-wrapper').length;
            if (currentPhotosCount + selectedFiles.length + newFiles.length > 10) {
                alert('No puedes subir más de 10 fotos en total.');
                return;
            }

            selectedFiles = [...selectedFiles, ...newFiles];
            renderPreviews();
        });

        function renderPreviews() {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const previewWrapper = document.createElement('div');
                    previewWrapper.className = 'preview-wrapper';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'preview-image';

                    const deleteBtn = document.createElement('button');
                    deleteBtn.innerHTML = '×';
                    deleteBtn.className = 'delete-btn';
                    deleteBtn.onclick = (e) => {
                        e.stopPropagation();
                        removeImage(index);
                    };

                    previewWrapper.appendChild(img);
                    previewWrapper.appendChild(deleteBtn);
                    previewContainer.appendChild(previewWrapper);
                }
            });

            updateFileInput();
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);
            renderPreviews();
        }

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('fotos').files = dataTransfer.files;
        }

        // Previsualización de nuevos videos (solo para profesores/admin)
        @if ($user && ($user->role == 'PROFESOR' || $user->role == 'ADMIN'))
            let selectedVideos = [];
            document.getElementById('videos').addEventListener('change', function (e) {
                const newVideos = Array.from(this.files);

                // Verificar límite de videos (2 en total)
                const currentVideosCount = document.querySelectorAll('#current-videos-container .preview-wrapper').length;
                if (currentVideosCount + selectedVideos.length + newVideos.length > 2) {
                    alert('No puedes subir más de 2 videos en total.');
                    return;
                }

                selectedVideos = [...selectedVideos, ...newVideos];
                renderVideoPreviews();
            });

            function renderVideoPreviews() {
                const previewContainer = document.getElementById('video-preview-container');
                previewContainer.innerHTML = '';

                selectedVideos.forEach((file, index) => {
                    if (file.type.startsWith('video/')) {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.className = 'preview-wrapper position-relative';
                        previewWrapper.style.width = '200px';
                        previewWrapper.style.height = 'auto';

                        const video = document.createElement('video');
                        video.src = URL.createObjectURL(file);
                        video.className = 'w-100';
                        video.controls = true;

                        const deleteBtn = document.createElement('button');
                        deleteBtn.innerHTML = '×';
                        deleteBtn.className = 'delete-btn';
                        deleteBtn.onclick = (e) => {
                            e.stopPropagation();
                            removeVideo(index);
                        };

                        previewWrapper.appendChild(video);
                        previewWrapper.appendChild(deleteBtn);
                        previewContainer.appendChild(previewWrapper);
                    }
                });

                updateVideoInput();
            }

            function removeVideo(index) {
                selectedVideos.splice(index, 1);
                renderVideoPreviews();
            }

            function updateVideoInput() {
                const dataTransfer = new DataTransfer();
                selectedVideos.forEach(file => dataTransfer.items.add(file));
                document.getElementById('videos').files = dataTransfer.files;
            }
        @endif
    </script>
</body>

</html>