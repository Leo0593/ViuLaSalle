@include('layouts.head')

<body>
    {{-- Vista Movil --}}
    @include('layouts.navheader', ['niveles' => $niveles, 'notificaciones' => $notificaciones])

    <!-- Mostrar la alerta si hay un mensaje de error en la sesión -->
    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    <div style="display: flex; align-items: center; justify-content: center;">
        <div class="main">
            <div class="opciones">
                {{-- Vista Desktop --}}
                @include('layouts.redirecciones', ['niveles' => $niveles])
            </div>

            <div class="contenido">
                @if (Auth::check())
                    <a href="#" class="box-crear-publicacion" data-toggle="modal" data-target="#exampleModalCenter">
                        <div class="box-crear-publicacion-header">
                            <div class="box-crear-publicacion-header-foto">
                                @if(Auth::check() && Auth::user()->avatar)
                                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar usuario"
                                        onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                                @else
                                    <img src="{{ asset('img/user-icon.png') }}" alt="Avatar por defecto">
                                @endif
                            </div>
                            <div class="box-crear-publicacion-header-texto">
                                ¿Qué estás pensando?
                            </div>
                        </div>
                        <div class="box-crear-publicacion-footer">
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-camera"></i>
                                <span>Foto</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-video"></i>
                                <span>Video</span>
                            </div>
                        </div>
                    </a>
                @endif

                @if(isset($publicaciones) && $publicaciones->isNotEmpty())
                    @foreach ($publicaciones as $publicacion)
                        @include('layouts.publicacion', ['publicacion' => $publicacion])
                    @endforeach
                @else
                    <p>No hay publicaciones disponibles.</p>
                @endif
            </div>

            <div class="perfil">
                @include('layouts.welcome-perfil', ['notificaciones' => $notificaciones])
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-usuario">
                        <div class="modal-usuario-foto">
                            @if(Auth::check() && Auth::user()->avatar)
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar usuario"
                                    onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                            @else
                                <img src="{{ asset('img/user-icon.png') }}" alt="Avatar por defecto">
                            @endif
                        </div>

                        <h5 class="modal-title" id="exampleModalLongTitle">
                            {{ Auth::check() ? Auth::user()->name : 'Invitado' }}
                        </h5>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('publicaciones.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @auth
                            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                        @endauth

                        <!-- Buscar Evento -->
                        <div class="form-group">
                            <label for="evento-search">Buscar Evento</label>
                            <input type="text" id="evento-search" class="form-control" placeholder="🔎 Buscar eventos...">

                            <!-- Input oculto para el evento seleccionado -->
                            <select name="id_evento" id="id_evento" class="form-control" style="display: none;">
                                <option value="0" selected>Sin evento</option> <!-- Valor por defecto -->

                                @foreach($eventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                                @endforeach
                            </select>

                            <!-- Lista de eventos sugeridos como botones -->
                            <div id="eventos-list" class="mt-2">
                                @foreach($eventos->take(5) as $evento)
                                    <button type="button" class="btn btn-outline-primary evento-btn"
                                        data-id="{{ $evento->id }}">
                                        {{ $evento->nombre }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Mostrar el evento seleccionado -->
                            <div id="evento-seleccionado" class="mt-3" style="display: none;">
                                <strong>Evento seleccionado:</strong>
                                <div id="evento-nombre" class="badge badge-primary m-1">
                                    <!-- Aquí se mostrará el evento -->
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="4"
                                required></textarea>
                        </div>

                        <!-- Buscar Etiquetas -->
                        <div class="form-group">
                            <label for="tags">Buscar Ciclos</label>
                            <input type="text" id="tags-search" class="form-control" placeholder="🔎 Buscar etiquetas...">

                            <div class="form-group mt-2">
                                <!-- Input oculto para enviar las categorías seleccionadas -->
                                <select name="categorias[]" id="categorias" class="form-control" multiple
                                    style="display: none;">
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" class="tag-option">{{ $categoria->nombre }}
                                        </option>
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
                                <strong>Ciclos seleccionadas:</strong>
                                <div id="selected-tags-list">
                                    <!-- Aquí se mostrarán las etiquetas seleccionadas -->
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" name="activar_comentarios" id="activar_comentarios"
                                class="form-check-input" value="1">
                            <label class="form-check-label" for="activar_comentarios">Permitir comentarios</label>
                        </div>

                        <div class="form-group mt-4">
                            <label for="fotos" class="btn btn-outline-primary rounded-pill"
                                style="font-size: 1.1rem; padding: 0.5rem 1.5rem;">
                                <i class="fas fa-camera me-2"></i> Seleccionar Fotos
                            </label>
                            <input type="file" name="fotos[]" id="fotos" class="d-none" multiple accept="image/*"
                                required>
                            <small class="text-muted d-block mt-2">Puedes seleccionar múltiples archivos</small>

                            <!-- Contenedor para previsualización -->
                            <div class="d-flex flex-wrap gap-3 mt-3" id="preview-container"></div>
                        </div>

                        @if ($user && ($user->role == 'PROFESOR' || $user->role == 'ADMIN'))
                            <div class="form-group mt-4">
                                <label for="videos" class="btn btn-outline-primary rounded-pill"
                                    style="font-size: 1.1rem; padding: 0.5rem 1.5rem;">
                                    <i class="fas fa-video me-2"></i> Seleccionar Videos
                                </label>
                                <input type="file" name="videos[]" id="videos" class="d-none" multiple accept="video/*">
                                <small class="text-muted d-block mt-2">Puedes seleccionar múltiples archivos</small>

                                <!-- Contenedor para previsualización -->
                                <div class="d-flex flex-wrap gap-3 mt-3" id="video-preview-container"></div>
                            </div>

                        @endif

                        <div class="modal-footer">
                            <button type="submit" class="btn-publicar">Publicar</button>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>


    <!-- Modal para imagen ampliada -->
    <div id="modalImagen" class="modal-imagen" style="display:none;">
        <span class="cerrar-modal" title="Cerrar">&times;</span>
        <div class="modal-contenedor">
            <img class="modal-contenido" id="imgAmpliada">

            <div class="modal-acciones">
                @auth
                    @if(auth()->user())
                        <a id="btnDescargarImagen" class="btn-descargar" href="#" target="_blank" title="Descargar imagen">
                            <i class="icono-descarga"></i> Descargar
                        </a>
                    @endif
                @endauth

                <button id="btnCancelar" class="btn-cancelar" title="Cerrar">
                    <i class="icono-cancelar"></i> Cancelar
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('/js/desglosable-niveles-curso.js') }}"></script>
    <script src="{{ asset(path: '/js/publicacion-modal.js') }}"></script>

    <!-- Script -->

    <!-- Script para el apartado de categorias-->
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

    <!-- Script para el apartado de eventos-->
    <script>
        $(document).ready(function () {
            const allEventos = @json($eventos);
            const sugeridos = allEventos.slice(0, 5); // Tomamos los 5 primeros

            function renderEventoButtons(eventos) {
                $('#eventos-list').empty();
                eventos.forEach(evt => {
                    $('#eventos-list').append(`
                    <button type="button" class="btn btn-outline-primary evento-btn" data-id="${evt.id}">
                        ${evt.nombre}
                    </button>
                `);
                });
            }

            $('#evento-search').on('input', function () {
                const searchText = $(this).val().toLowerCase();
                if (searchText === '') {
                    renderEventoButtons(sugeridos);
                } else {
                    const filtrados = allEventos.filter(evt => evt.nombre.toLowerCase().includes(searchText));
                    renderEventoButtons(filtrados);
                }
            });

            $(document).on('click', '.evento-btn', function () {
                const eventoId = $(this).data('id').toString();
                const evento = allEventos.find(e => e.id == eventoId);

                if (evento) {
                    $('#id_evento').val(eventoId);
                    $('#evento-nombre').text(evento.nombre);
                    $('#evento-seleccionado').show();
                }

                $('#evento-search').val('');
                renderEventoButtons(sugeridos); // Mostrar los sugeridos de nuevo
            });
        });
    </script>

    <!-- Script para el selector de archivos -->
    <script>
        // Seleccionar los iconos
        const iconoImagen = document.getElementById('icono-imagen');
        const iconoVideo = document.getElementById('icono-video');
        const fileInput = document.getElementById('file-input');

        // Asignar eventos de clic para abrir el selector de archivos
        iconoImagen.addEventListener('click', function () {
            fileInput.accept = 'image/*'; // Solo permitir imágenes
            fileInput.click();  // Abre el selector de archivos
        });

        iconoVideo.addEventListener('click', function () {
            fileInput.accept = 'video/*'; // Solo permitir videos
            fileInput.click();  // Abre el selector de archivos
        });

        // Opcional: Puedes agregar un evento para mostrar el archivo seleccionado
        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                alert('Archivo seleccionado: ' + fileInput.files[0].name);
            }
        });

    </script>

    <script>
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
                    previewWrapper.style.position = 'relative';
                    previewWrapper.style.width = '100px';
                    previewWrapper.style.height = '100px';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'preview-image';
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.border = '1px solid #dee2e6';
                    img.style.transition = 'all 0.3s ease';

                    const deleteBtn = document.createElement('button');
                    deleteBtn.innerHTML = '&times;';
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
    </script>

    <script>
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
                    previewWrapper.style.position = 'relative';
                    previewWrapper.style.width = '100px';
                    previewWrapper.style.height = '100px';

                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.className = 'preview-image';
                    video.style.width = '100%';
                    video.style.height = '100%';
                    video.style.objectFit = 'cover';
                    video.style.borderRadius = '8px';
                    video.style.border = '1px solid #dee2e6';
                    video.muted = true;
                    video.playsInline = true;
                    video.loop = true;
                    video.autoplay = true;

                    const deleteBtn = document.createElement('button');
                    deleteBtn.innerHTML = '&times;';
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
    </script>


    <!-- Ventana de notificaciones -->
    <script>
        function toggleNotificaciones() {
            const ventanas = document.querySelectorAll("#ventanaNotificaciones");

            let algunaVisible = false;
            ventanas.forEach(ventana => {
                if (ventana.classList.contains("show")) {
                    algunaVisible = true;
                }
            });

            ventanas.forEach(ventana => {
                if (algunaVisible) {
                    ventana.classList.remove("show");
                } else {
                    ventana.classList.add("show");
                }
            });
        }

        document.addEventListener("click", function (event) {
            const ventanas = document.querySelectorAll("#ventanaNotificaciones");
            const botones = document.querySelectorAll(".notif-btn");

            let dentroDeVentanaOBoton = false;

            ventanas.forEach(ventana => {
                if (ventana.contains(event.target)) {
                    dentroDeVentanaOBoton = true;
                }
            });

            botones.forEach(boton => {
                if (boton.contains(event.target)) {
                    dentroDeVentanaOBoton = true;
                }
            });

            if (!dentroDeVentanaOBoton) {
                ventanas.forEach(ventana => {
                    ventana.classList.remove("show");
                });
            }
        });
    </script>


    <!-- Opciones/Reportar -->
    <script src="{{ asset('/js/reportes.js') }}"></script>
    <script src="{{ asset('/js/mostrar-comentarios.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.like-btn').click(function () {
                let button = $(this);
                let icon = button.find('i');
                let publicacionId = button.data('id');

                $.ajax({
                    url: '/publicaciones/' + publicacionId + '/like',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // Actualizar contador
                        button.siblings('.like-count').text(response.likes);

                        // Cambiar clase del ícono
                        if (response.liked) {
                            icon.removeClass('fa-regular').addClass('fa-solid').css('color', 'red');
                        } else {
                            icon.removeClass('fa-solid').addClass('fa-regular').css('color', 'black');
                        }
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
@include('layouts.footer')