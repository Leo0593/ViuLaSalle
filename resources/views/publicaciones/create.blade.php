@include('layouts.head')

<body class="bg-light">
    @include('layouts.navheader')
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-auto mt-3" style="max-width: 800px; border-left: 4px solid #dc3545;">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container py-4 mt-8" style="margin-top: 150px !important;">
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
                        <small class="text-muted">Creando nueva publicación</small>
                    </div>
                </div>
            </div>

            <!-- Cuerpo del formulario -->
            <div class="card-body p-4">
                <form action="{{ route('publicaciones.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">

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
                                   placeholder="Buscar eventos...">
                        </div>
                        
                        <!-- Input oculto para el evento seleccionado -->
                        <select name="id_evento" id="id_evento" class="form-control" style="display: none;">
                            <option value="0" selected>Sin evento</option>
                            @foreach($eventos as $evento)
                                <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                            @endforeach
                        </select>

                        <!-- Eventos sugeridos -->
                        <div id="eventos-list" class="d-flex flex-wrap gap-2 mb-2">
                            @foreach($eventos->take(5) as $evento)
                                <button type="button" class="btn btn-outline-primary evento-btn rounded-pill px-3"
                                    data-id="{{ $evento->id }}">
                                    {{ $evento->nombre }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Evento seleccionado -->
                        <div id="evento-seleccionado" class="mt-2" style="display: none;">
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-2">Evento seleccionado:</span>
                                <span id="evento-nombre" class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                    <!-- Aquí se mostrará el evento -->
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-edit me-2 text-primary"></i>Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion" class="form-control shadow-sm" rows="4" 
                                  placeholder="¿Qué quieres compartir hoy?" required></textarea>
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
                                    data-id="{{ $categoria->id }}">
                                    {{ $categoria->nombre }}
                                </button>
                            @endforeach
                        </div>
                        
                        <!-- Input oculto para categorías seleccionadas -->
                        <select name="categorias[]" id="categorias" class="form-control" multiple style="display: none;">
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        
                        <!-- Etiquetas seleccionadas -->
                        <div id="selected-tags" class="mt-3">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <span class="text-muted">Seleccionadas:</span>
                                <div id="selected-tags-list" class="d-flex flex-wrap gap-2">
                                    <!-- Aquí se mostrarán las etiquetas seleccionadas -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Multimedia -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-images me-2 text-primary"></i>Multimedia
                        </label>
                        
                        <!-- Fotos -->
                        <div class="mb-3">
                            <label for="fotos" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                <i class="fas fa-camera me-2"></i> Seleccionar Fotos
                                <input type="file" name="fotos[]" id="fotos" class="d-none" multiple accept="image/*" required>
                            </label>
                            <small class="text-muted ms-2">Máx. 10 fotos</small>
                            
                            <!-- Previsualización fotos -->
                            <div class="d-flex flex-wrap gap-3 mt-3" id="preview-container"></div>
                        </div>
                        
                        <!-- Videos (solo para profesores/admin) -->
                        @if ($user && ($user->role == 'PROFESOR' || $user->role == 'ADMIN'))
                            <div class="mb-3">
                                <label for="videos" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                    <i class="fas fa-video me-2"></i> Seleccionar Videos
                                    <input type="file" name="videos[]" id="videos" class="d-none" multiple accept="video/*">
                                </label>
                                <small class="text-muted ms-2">Máx. 2 videos</small>
                                
                                <!-- Previsualización videos -->
                                <div class="d-flex flex-wrap gap-3 mt-3" id="video-preview-container"></div>
                            </div>
                        @endif
                    </div>

                    <!-- Configuración -->
                    <div class="mb-4">
                        <div class="form-check form-switch ps-0">
                            <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" 
                                   name="activar_comentarios" id="activar_comentarios" value="1" checked>
                            <label class="form-check-label fw-bold text-dark" for="activar_comentarios">
                                <i class="fas fa-comments me-2 text-primary mr"></i> Permitir comentarios
                            </label>
                        </div>
                    </div>

                    <!-- Botón de publicación -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                            <i class="fas fa-paper-plane me-2"></i> Publicar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <!-- Scripts (se mantienen igual que en tu versión original) -->
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
                    $('#categorias-list').append(`
                        <button type="button" class="btn btn-outline-primary category-btn rounded-pill px-3" data-id="${cat.id}">
                            ${cat.nombre}
                        </button>
                    `);
                });
            }

            // Función para renderizar botones de eventos
            function renderEventoButtons(eventos) {
                $('#eventos-list').empty();
                eventos.forEach(evt => {
                    $('#eventos-list').append(`
                        <button type="button" class="btn btn-outline-primary evento-btn rounded-pill px-3" data-id="${evt.id}">
                            ${evt.nombre}
                        </button>
                    `);
                });
            }

            // Búsqueda de etiquetas
            $('#tags-search').on('input', function () {
                const searchText = $(this).val().toLowerCase();
                if (searchText === '') {
                    renderCategoryButtons(defaultCategories);
                } else {
                    const filtered = allCategories.filter(cat => cat.nombre.toLowerCase().includes(searchText));
                    renderCategoryButtons(filtered);
                }
            });

            // Búsqueda de eventos
            $('#evento-search').on('input', function () {
                const searchText = $(this).val().toLowerCase();
                if (searchText === '') {
                    renderEventoButtons(sugeridos);
                } else {
                    const filtrados = allEventos.filter(evt => evt.nombre.toLowerCase().includes(searchText));
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

                const isInSugeridas = defaultCategories.some(cat => cat.id.toString() === tagId);
                if (!isInSugeridas) {
                    renderCategoryButtons(defaultCategories);
                }
            });

            // Seleccionar evento
            $(document).on('click', '.evento-btn', function () {
                const eventoId = $(this).data('id').toString();
                const evento = allEventos.find(e => e.id == eventoId);

                if (evento) {
                    $('#id_evento').val(eventoId);
                    $('#evento-nombre').text(evento.nombre);
                    $('#evento-seleccionado').show();
                }

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
            });

            // Inicializar
            updateSelectedTags();
            renderEventoButtons(sugeridos);
        });

        // Previsualización de imágenes
        let selectedFiles = [];
        document.getElementById('fotos').addEventListener('change', function (e) {
            selectedFiles = [...selectedFiles, ...Array.from(this.files)];
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

        // Previsualización de videos (solo para profesores/admin)
        @if ($user && ($user->role == 'PROFESOR' || $user->role == 'ADMIN'))
            let selectedVideos = [];
            document.getElementById('videos').addEventListener('change', function (e) {
                selectedVideos = [...selectedVideos, ...Array.from(this.files)];
                renderVideoPreviews();
            });

            function renderVideoPreviews() {
                const previewContainer = document.getElementById('video-preview-container');
                previewContainer.innerHTML = '';

                selectedVideos.forEach((file, index) => {
                    if (file.type.startsWith('video/')) {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.className = 'preview-wrapper';
                        
                        const video = document.createElement('video');
                        video.src = URL.createObjectURL(file);
                        video.className = 'preview-image';
                        video.muted = true;
                        video.playsInline = true;
                        video.loop = true;
                        video.autoplay = true;
                        
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