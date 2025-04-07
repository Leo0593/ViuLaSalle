@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div style="display: flex; align-items: center; justify-content: center;">
        <div class="main">

            <div class="opciones">
                <div class="opciones-bar-separator">Home</div>
                <li class="opciones-bar-item">
                    <a class="opciones-bar-link" >
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
                                    <img 
                                        src="{{ Storage::url(Auth::user()->avatar) }}" 
                                        alt="Avatar usuario" 
                                        onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                                @else
                                    <img 
                                        src="{{ asset('img/user-icon.png') }}" 
                                        alt="Avatar por defecto">
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
                                    <img src="{{ $publicacion->usuario->avatar ? Storage::url($publicacion->usuario->avatar) : asset('img/user-icon.png') }}" alt="Avatar usuario">
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
                                            <div class="box-publicacion-media-item box-publicacion-img" style="background-image: url('{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}');"></div>
                                        @endforeach

                                        <!-- Mostrar videos -->
                                        @foreach($publicacion->videos as $video)
                                            <div class="box-publicacion-media-item box-publicacion-video">
                                                <video autoplay controls loop>
                                                    <source src="{{ asset('storage/publicvideos/' . $video->ruta_video) }}" type="video/mp4">
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
                                        <div class="box-publicacion-img" style="background-image: url('{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}');"></div>
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
                                                <source src="{{ asset('storage/publicvideos/' . $video->ruta_video) }}" type="video/mp4">
                                            </video>
                                        </div>
                                    @endforeach
                                </div>

                            @else
                                <div class="box-publicacion-img" style="background-image: url('{{ asset('img/default.jpg') }}');"></div>
                            @endif

                            <div class="box-publicacion-footer">
                                <div class="box-publicacion-buttons">
                                    <!-- Botón de like con ícono dinámico -->
                                    <button class="like-btn" data-id="{{ $publicacion->id }}"
                                        style="color: {{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'red' : 'black' }};">
                                        <i class="fa-heart {{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'fa-solid' : 'fa-regular' }}"></i>
                                    </button>
                                    <!-- 
                                    <button>
                                        <i class="fa-regular fa-comments"></i>
                                    </button>
                                    <i class="fa-solid fa-heart" style="font-size: 25px;"></i> -->

                                    <div class="descripcion">
                                        <strong>{{ $publicacion->usuario->name }}: </strong>
                                        {{ Str::words($publicacion->descripcion, 100, '...') }}
                                    </div>
                                </div>
                                
                                <div class="box-publicacion-comentarios">
                                    <p><strong>User 1: </strong> Hola</p>
                                    <p><strong>User 2: </strong> Hola</p>
                                    <p><strong>User 3: </strong> Hola</p>
                                    <p><strong>User 4: </strong> Hola</p>
                                    <p><strong>User 5: </strong> Hola</p>
                                    <p><strong>User 6: </strong> Hola</p>
                                    <p><strong>User 7: </strong> Hola</p>
                                    <p><strong>User 8: </strong> Hola</p>
                                    <p><strong>User 9: </strong> Hola</p>
                                    <p><strong>User 10: </strong> Hola</p>
                                    <p><strong>User 11: </strong> Hola</p>
                                    <p><strong>User 12: </strong> Hola</p>
                                    <p><strong>User 13: </strong> Hola</p>
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
                            <img 
                                src="{{ Storage::url(Auth::user()->avatar) }}" 
                                alt="Avatar usuario" 
                                onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                        @else
                            <img 
                                src="{{ asset('img/user-icon.png') }}" 
                                alt="Avatar por defecto">
                        @endif
                    </div>


                    <!-- Overlay borroso y botón -->
                    @if(!Auth::check())
                    <div class="perfil-overlay">
                        <button class="btn-login"><strong>Iniciar Sesión</strong></button>
                    </div>
                    @endif

                    <div class="perfil-info">
                        <div class="center-text" style="margin-bottom: 10px;">
                            <h3>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</h3>
                        </div>
                        <p><strong>Correo: </strong> {{ Auth::check() ? Auth::user()->email : 'No disponible' }}</p>
                        <p><strong>Teléfono: </strong> {{ Auth::check() ? Auth::user()->phone : 'No disponible' }}</p>
                        <p><strong>Fecha de nacimiento: </strong> {{ Auth::check() ? Auth::user()->birthdate : 'No disponible' }}</p>
                        <p><strong>Descripción: </strong> {{ Auth::check() ? Auth::user()->description : 'No disponible' }}</p>
                        <p><strong>Ubicación: </strong> {{ Auth::check() ? Auth::user()->location: 'No disponible' }}</p>
                    </div>
                </div>
            </div>
            
        </div> 
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-usuario">
                        <div class="modal-usuario-foto">
                            @if(Auth::check() && Auth::user()->avatar)
                                <img 
                                    src="{{ Storage::url(Auth::user()->avatar) }}" 
                                    alt="Avatar usuario" 
                                    onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                            @else
                                <img 
                                    src="{{ asset('img/user-icon.png') }}" 
                                    alt="Avatar por defecto">
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
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-publicar">Publicar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        // Seleccionar los iconos
        const iconoImagen = document.getElementById('icono-imagen');
        const iconoVideo = document.getElementById('icono-video');
        const fileInput = document.getElementById('file-input');

        // Asignar eventos de clic para abrir el selector de archivos
        iconoImagen.addEventListener('click', function() {
            fileInput.accept = 'image/*'; // Solo permitir imágenes
            fileInput.click();  // Abre el selector de archivos
        });

        iconoVideo.addEventListener('click', function() {
            fileInput.accept = 'video/*'; // Solo permitir videos
            fileInput.click();  // Abre el selector de archivos
        });

        // Opcional: Puedes agregar un evento para mostrar el archivo seleccionado
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                alert('Archivo seleccionado: ' + fileInput.files[0].name);
            }
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const publicacionesContainers = document.querySelectorAll('.box-publicacion-img-container');
            
            // Recorremos todas las publicaciones
            publicacionesContainers.forEach((container) => {
                const dots = container.closest('.box-publicacion').querySelectorAll('.dot');
                
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
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const publicacionesContainers = document.querySelectorAll('.box-publicacion-media-container-media');
            
            // Recorremos todas las publicaciones
            publicacionesContainers.forEach((container) => {
                const dots = container.closest('.box-publicacion').querySelectorAll('.dot');
                
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
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            jQuery('.like-btn').click(function () {
                let button = $(this);
                let publicacionId = button.data('id');

                jQuery.ajax({
                    url: '/publicaciones/' + publicacionId + '/like',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // Actualizar el contador de likes
                        button.find('.like-count').text(response.likes);

                        // Cambiar el color y el ícono según si el usuario dio like o no
                        if (response.liked) {
                            button.css('color', 'red');
                            button.find('i').removeClass('fa-regular').addClass('fa-solid'); // Corazón lleno
                        } else {
                            button.css('color', 'black');
                            button.find('i').removeClass('fa-solid').addClass('fa-regular'); // Corazón vacío
                        }
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>