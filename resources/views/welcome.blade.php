@include('layouts.head')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<body>

    @include('layouts.navheader')
    <!-- Mostrar la alerta si hay un mensaje de error en la sesión -->
    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

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

                <li class="opciones-bar-item">
                    <a class="opciones-bar-link" href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-tachometer-alt"></i> <!-- Icono de dashboard -->
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="opciones-bar-item">
                    <a class="opciones-bar-link" href="{{ route('niveles.index') }}">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Niveles Educativos</span>
                    </a>
                </li>

                <li class="opciones-bar-item">
                    <a class="opciones-bar-link" href="{{ route('eventos.todos') }}">
                        <i class="fa-solid fa-calendar"></i>
                        <span>Eventos</span>
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

                                                <div class="box-publicacion-header-name">
                                                    {{ $publicacion->usuario->name }}
                                                </div>

                                                <div class="box-publicacion-header-options">
                                                    <button type="button" class="ellipsis-btn">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>

                                                    @php
                                                        $yaReportado = \App\Models\Reporte::where('user_id', auth()->id())
                                                            ->where('publicacion_id', $publicacion->id)
                                                            ->exists();
                                                    @endphp

                                                    <ul class="menu-opciones">
                                                        @if (!$yaReportado)
                                                            <li>
                                                                <form action="{{ route('publicaciones.reportar', $publicacion->id) }}" method="POST"
                                                                    style="display:inline;"
                                                                    onsubmit="return confirm('¿Estás seguro de que deseas reportar esta publicación?');">
                                                                    @csrf
                                                                    <button type="submit" class="btn-reportar">
                                                                        <!-- style="background: none; border: none; padding: 0; color: red; cursor: pointer;" -->
                                                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Reportar
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @else
                                                            <li style="color: gray; cursor: not-allowed;">
                                                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Reportado
                                                            </li>
                                                        @endif
                                                    </ul>
                                                    <!-- Menú flotante 
                                                                                                                                                                                                                                                                                                                                                                                                                                            <ul class="menu-opciones">
                                                                                                                                                                                                                                                                                                                                                                                                                                                <li><a href="#">Ver publicación</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                <li><a href="#">Editar</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                <li><a href="#">Eliminar</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                                            </ul>-->
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
                                                    <button class="like-btn" data-id="{{ $publicacion->id }}"
                                                        style="background: none; border: none; cursor: pointer;">
                                                        <i class="{{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'fa-solid' : 'fa-regular' }} fa-heart"
                                                            style="font-size: 25px; color: {{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'red' : 'black' }};"></i>
                                                    </button>

                                                    <span class="like-count">{{ $publicacion->likes_count }}</span>

                                                    <!--
                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="fa-regular fa-heart" style="font-size: 25px;"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="fa-solid fa-heart" style="font-size: 25px;"></i> 
                                                                                                                                                                                                                                                                                                                                                                                                                                            -->

                                                    <!-- Botón de comentarios -->
                                                    @if($publicacion->activar_comentarios == 1)
                                                        <button class="btn-comentarios" data-id="{{ $publicacion->id }}">
                                                            <i class="fa-regular fa-comments"></i>
                                                        </button>
                                                    @endif


                                                    <!--
                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="fa-solid fa-heart" style="font-size: 25px;"></i> 
                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="fa-regular fa-comments" style="font-size: 25px;"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                            -->

                                                    <div class="descripcion">
                                                        <strong>{{ $publicacion->usuario->name }}: </strong>
                                                        {{ Str::words($publicacion->descripcion, 100, '...') }}
                                                    </div>
                                                </div>

                                                <!-- Caja de comentarios -->
                                                <div class="box-publicacion-comentarios" id="comentarios-{{ $publicacion->id }}">
                                                    @if($publicacion->comentarios->isNotEmpty())
                                                        @foreach($publicacion->comentarios as $comentario)
                                                            <div class="comentario">
                                                                <div class="box-publicacion-header-user"
                                                                    style="margin-right: 0px; box-shadow: 0 0 0 rgba(0, 0, 0, 0); border: 0.8px solid rgb(200 200 200 / 50%);">
                                                                    <img src="{{ $publicacion->usuario->avatar ? Storage::url($publicacion->usuario->avatar) : asset('img/user-icon.png') }}"
                                                                        alt="Avatar usuario">
                                                                </div>
                                                                <strong>{{ $comentario->usuario->name ?? 'User' }}:</strong>
                                                                <p>{{ $comentario->contenido }}</p>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p>No hay comentarios aún.</p>
                                                    @endif

                                                    @if(Auth::check())
                                                        <div>
                                                            <form action="{{ route('comentarios.store') }}" method="POST"
                                                                class="agregar-comentario">
                                                                @csrf
                                                                <div class="box-crear-publicacion-header-foto"
                                                                    style="margin-right: 0px; box-shadow: 0 0 0 rgba(0, 0, 0, 0); border: 0.8px solid rgb(200 200 200 / 50%);">
                                                                    @if(Auth::check() && Auth::user()->avatar)
                                                                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar usuario"
                                                                            onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                                                                    @else
                                                                        <img src="{{ asset('img/user-icon.png') }}" alt="Avatar por defecto">
                                                                    @endif
                                                                </div>

                                                                <input type="hidden" name="id_publicacion" value="{{ $publicacion->id }}">
                                                                <input class="box-crear-publicacion-header-texto"
                                                                    style="padding: 10px; height: auto;" type="text" name="contenido"
                                                                    placeholder="Escribe un comentario..." required>
                                                                <button class="enviar-comentario" type="submit"><i class="fa fa-paper-plane"
                                                                        aria-hidden="true"></i></button>
                                                            </form>
                                                        </div>
                                                    @endif
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

                @if (Auth::check())
                    <div style="whidth: 100%; display: flex; gap: 10px; flex-direction: column;">
                                <!-- Botón Editar Perfil -->
                                <a href="{{ route('profile.edit') }}"
                                    style="background-color: #0d6efd; color: white; padding: 8px 16px; border: none; border-radius: 10px; text-decoration: none; display: flex; align-items: center;">
                                    <i class="fa fa-user-edit" style="margin-right: 5px;"></i> Editar Perfil
                                </a>

                                <!-- Botón Cerrar Sesión -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        style="background-color: #dc3545; color: white; padding: 8px 16px; border: none; border-radius: 10px; cursor: pointer; display: flex; align-items: center; width: 100%;">
                                        <i class="fa fa-sign-out-alt" style="margin-right: 5px;"></i> Cerrar Sesión
                                    </button>
                                </form>
                    </div>
                @endif
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

                        <div class="form-group mt-4">
                            <label for="fotos" class="btn btn-outline-primary rounded-pill"
                                style="font-size: 1.1rem; padding: 0.5rem 1.5rem;">
                                <i class="fas fa-camera me-2"></i> Seleccionar Fotos
                            </label>
                            <input type="file" name="fotos[]" id="fotos" class="d-none" multiple accept="image/*">
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

    <!-- Script para mostrar/ocultar comentarios -->
    <script>
        $(document).ready(function () {
            $('.btn-comentarios').click(function () {
                const id = $(this).data('id');
                $('#comentarios-' + id).slideToggle(); // cambia display entre none y block con animación
            });
        });
    </script>

    <!-- Script para el menú de opciones -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleMenus = document.querySelectorAll('.ellipsis-btn');

            toggleMenus.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation(); // ¡evita que se cierre justo después!

                    const menu = this.nextElementSibling;

                    // Cerrar todos menos el actual
                    document.querySelectorAll('.menu-opciones').forEach(m => {
                        if (m !== menu) m.style.display = 'none';
                    });

                    // Mostrar u ocultar este menú
                    menu.style.display = (getComputedStyle(menu).display === 'none') ? 'flex' : 'none';
                });
            });

            // Cierra todos los menús si haces clic fuera
            document.addEventListener('click', function () {
                document.querySelectorAll('.menu-opciones').forEach(menu => {
                    menu.style.display = 'none';
                });
            });
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


    <style>
        .preview-wrapper {
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }

        .preview-wrapper:hover .preview-image {
            filter: brightness(0.7);
        }

        .delete-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 32px;
            height: 32px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            cursor: pointer;
            z-index: 2;
        }

        .preview-wrapper:hover .delete-btn {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        .delete-btn:hover {
            background-color: #bb2d3b;
            transform: translate(-50%, -50%) scale(1.1);
        }
    </style>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>