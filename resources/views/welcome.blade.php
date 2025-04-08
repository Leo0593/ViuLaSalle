@include('layouts.head')

<body>

    @include('layouts.navheader')

    <div style="display: flex; align-items: center; justify-content: center;">
        <div class="main">

            <div class="opciones">
                <div class="opciones-bar-separator">Home</div>
                <li class="opciones-bar-item">
                    <a class="opciones-bar-link">
                        <i class="fa-solid fa-house"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="opciones-bar-item">
                    <a class="opciones-bar-link" href="{{ route('info.index') }}">
                        <i class="fa-solid fa-user"></i>
                        <span>Perfil</span>
                    </a>
                </li>

                <div class="opciones-bar-separator">Interfaces</div>
                <li class="opciones-bar-item">
                    <a class="opciones-bar-link">
                        <i class="fa-solid fa-info-circle"></i>
                        <span>ESO</span>
                    </a>
                </li>

                <li class="opciones-bar-item">
                    <a class="opciones-bar-link">
                        <i class="fa-solid fa-info-circle"></i>
                        <span>Batxillerat</span>
                    </a>
                </li>

                <div class="opciones-bar-separator">Ciclos</div>
                <li class="opciones-bar-item">
                    <a class="opciones-bar-link">
                        <i class="fa-solid fa-info-circle"></i>
                        <span>CFGM</span>
                    </a>
                </li>
                <li class="opciones-bar-item">
                    <a class="opciones-bar-link">
                        <i class="fa-solid fa-info-circle"></i>
                        <span>CFGS</span>
                    </a>
                </li>
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
                        <div class="box-publicacion">
                            <div class="box-publicacion-header">
                                <div class="box-publicacion-header-user">
                                    <img src="{{ $publicacion->usuario->avatar ? Storage::url($publicacion->usuario->avatar) : asset('img/user-icon.png') }}"
                                        alt="Avatar usuario">
                                </div>
                                {{ $publicacion->usuario->name }}

                                <div class="box-publicacion-header-options">
                                    <button type="button" class="">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                </div>
                            </div>

                            @if($publicacion->fotos->count() > 0 && $publicacion->videos->count() > 0)
                                <div class="box-publicacion-media-container">
                                    <div class="box-publicacion-media-container-media">
                                        <!-- Mostrar fotos -->
                                        @foreach($publicacion->fotos as $foto)
                                            <div class="box-publicacion-media-item box-publicacion-img"
                                                style="background-image: url('{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}');">
                                            </div>
                                        @endforeach

                                        <!-- Mostrar videos -->
                                        @foreach($publicacion->videos as $video)
                                            <div class="box-publicacion-media-item box-publicacion-video">
                                                <video autoplay controls loop>
                                                    <source src="{{ asset('storage/publicvideos/' . $video->ruta_video) }}"
                                                        type="video/mp4">
                                                </video>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($publicacion->fotos->count() + $publicacion->videos->count() > 1)
                                        <div class="dots-container">
                                            <!-- Crear un punto por cada foto -->
                                            @foreach($publicacion->fotos as $foto)
                                                <span class="dot"></span>
                                            @endforeach

                                            <!-- Crear un punto por cada video -->
                                            @foreach($publicacion->videos as $video)
                                                <span class="dot"></span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <!-- Si hay fotos -->
                            @elseif($publicacion->fotos->count() > 0)
                                <div class="box-publicacion-img-container">
                                    @foreach($publicacion->fotos as $foto)
                                        <div class="box-publicacion-img"
                                            style="background-image: url('{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}');">
                                        </div>
                                    @endforeach
                                </div>

                                @if($publicacion->fotos->count() > 1)
                                    <div class="dots-container">
                                        @foreach($publicacion->fotos as $foto)
                                            <span class="dot"></span>
                                        @endforeach
                                    </div>
                                @endif
                                <!-- Si hay videos -->
                            @elseif($publicacion->videos->count() > 0)
                                <div class="box-publicacion-video-container">
                                    @foreach($publicacion->videos as $video)
                                        <div class="box-publicacion-video">
                                            <video autoplay controls loop>
                                                <source src="{{ asset('storage/publicvideos/' . $video->ruta_video) }}"
                                                    type="video/mp4">
                                            </video>
                                        </div>
                                    @endforeach
                                </div>

                            @else
                                <div class="box-publicacion-img" style="background-image: url('{{ asset('img/default.jpg') }}');">
                                </div>
                            @endif

                            <div class="box-publicacion-footer">
                                <div class="box-publicacion-buttons">
                                    <i class="fa-regular fa-heart" style="font-size: 25px;"></i>
                                    <!--
                                                                    <i class="fa-solid fa-heart" style="font-size: 25px;"></i> -->
                                    <i class="fa-regular fa-comments" style="font-size: 25px;"></i>
                                    <div class="descripcion">
                                        <strong>{{ $publicacion->usuario->name }}: </strong>
                                        {{ Str::words($publicacion->descripcion, 100, '...') }}
                                    </div>
                                </div>

                                <div class="box-publicacion-comentarios">
                                    <p><strong>User: </strong>Hola</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No hay publicaciones disponibles.</p>
                @endif
            </div>

            <div class="perfil">
                <div class="perfil-box">
                    <div class="perfil-header">
                        <img src="../../img/Fondo.png" alt="Fondo de perfil">
                    </div>
                    <div class="perfil-foto">
                        @if(Auth::check() && Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar usuario"
                                onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                        @else
                            <img src="{{ asset('img/user-icon.png') }}" alt="Avatar por defecto">
                        @endif
                    </div>

                    <!-- Overlay borroso y botón -->
                    @if(!Auth::check())
                        <div class="perfil-overlay">
                            <!--|<button class="btn-login"><strong>Iniciar Sesión</strong></button> -->
                            <a href="{{ route('login') }}" class="btn-login">
                                <strong>Iniciar Sesión</strong>
                            </a>

                        </div>
                    @endif

                    <div class="perfil-info">
                        <div class="center-text" style="margin-bottom: 10px;">
                            <h3>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</h3>
                        </div>
                        <p><strong>Correo: </strong> {{ Auth::check() ? Auth::user()->email : 'No disponible' }}</p>
                        <p><strong>Teléfono: </strong> {{ Auth::check() ? Auth::user()->phone : 'No disponible' }}</p>
                        <p><strong>Fecha de nacimiento: </strong>
                            {{ Auth::check() ? Auth::user()->birthdate : 'No disponible' }}</p>
                        <p><strong>Descripción: </strong>
                            {{ Auth::check() ? Auth::user()->description : 'No disponible' }}</p>
                        <p><strong>Ubicación: </strong> {{ Auth::check() ? Auth::user()->location : 'No disponible' }}
                        </p>
                    </div>
                </div>
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

                        <!-- Buscar Etiquetas -->
                        <div class="form-group">
                            <label for="tags">Buscar Etiquetas</label>
                            <input type="text" id="tags-search" class="form-control" placeholder="Buscar etiquetas...">

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
                                <strong>Etiquetas seleccionadas:</strong>
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

                        <div class="modal-footer">
                            <button type="submit" class="btn-publicar">Publicar</button>
                        </div>

                    </form>
                </div>

                <!--<div class="modal-body">
                    <textarea class="form-control" id="publicacion-texto" rows="5" placeholder="Escribe tu publicación aquí..."></textarea>
                    
                    <div class="modal-archivos">
                        <div class="icono" id="icono-imagen">
                            <i class="fa-solid fa-image"></i> 
                        </div>
                        <div class="icono" id="icono-video">
                            <i class="fa-solid fa-video"></i> 
                        </div>
                    </div>

                    <input type="file" id="file-input" style="display: none;" accept="image/*, video/*">
                </div>-->


            </div>
        </div>
    </div>

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
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.querySelector('.box-publicacion-img-container');
            const dots = document.querySelectorAll('.dot');

            // Función para actualizar los puntos
            function updateDots() {
                const scrollPosition = container.scrollLeft;
                const containerWidth = container.offsetWidth;
                const totalImages = dots.length;
                const activeIndex = Math.floor(scrollPosition / containerWidth);

                dots.forEach((dot, index) => {
                    if (index === activeIndex) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }

            // Actualizamos los puntos cuando se hace scroll
            container.addEventListener('scroll', updateDots);

            // Inicializamos el estado de los puntos
            updateDots();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const likeButtons = document.querySelectorAll('.btn-like');

            likeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const icon = this.querySelector('i');
                    const publicacionId = this.getAttribute('data-id');

                    fetch('/publicaciones/' + publicacionId + '/like', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Toggle icon según la respuesta
                        if (data.liked) {
                            icon.classList.remove('fa-regular');
                            icon.classList.add('fa-solid');
                        } else {
                            icon.classList.remove('fa-solid');
                            icon.classList.add('fa-regular');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>