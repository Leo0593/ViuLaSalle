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
                            <img src="../../img/user-icon.png" alt="Foto de perfil">
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
                                <div class="box-publicacion-header-user"></div>
                                {{ $publicacion->usuario->name }}
                            </div>

                            @if($publicacion->fotos->count() > 0)
                                <div class="box-publicacion-img-container">
                                    @foreach($publicacion->fotos as $foto)
                                        <div class="box-publicacion-img" style="background-image: url('{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}');">
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
                            @else
                                <div class="box-publicacion-img" style="background-image: url('{{ asset('img/default.jpg') }}');"></div>
                            @endif

                            <div class="box-publicacion-footer">
                                <i class="fa-regular fa-heart" style="font-size: 25px;"></i>
                                <i class="fa-solid fa-heart" style="font-size: 25px;"></i>
                                <i class="fa-regular fa-comments" style="font-size: 25px;"></i>
                                <div class="descripcion">
                                    <strong>{{ $publicacion->usuario->name }}: </strong>
                                    {{ Str::words($publicacion->descripcion, 100, '...') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No hay publicaciones disponibles.</p>
                @endif

                

                <div class="box-publicacion">
                    <div class="box-publicacion-header">
                        <div class="box-publicacion-header-user"></div>
                        User
                    </div>

                    <div class="box-publicacion-img" style="background-image: url('../../img/salle.jpeg');"></div>

                    <div class="box-publicacion-footer">
                        <i class="fa-regular fa-heart" style="font-size: 25px;"></i>
                        <i class="fa-solid fa-heart" style="font-size: 25px;"></i>
                        <i class="fa-regular fa-comments" style="font-size: 25px;"></i>
                        <div class="descripcion">
                            User: descripcion de la publicacion donde puede haber
                        </div>
                    </div>
                </div>

                <div class="box-publicacion">
                    <div class="box-publicacion-header">
                        <div class="box-publicacion-header-user"></div>
                        User
                    </div>

                    <div class="box-publicacion-img" style="background-image: url('../../img/navidad.webp');"></div>

                    <div class="box-publicacion-footer">
                        <i class="fa-regular fa-heart" style="font-size: 25px;"></i>
                        <i class="fa-regular fa-comments" style="font-size: 25px;"></i>
                    </div>
                </div>

                <div class="box-publicacion">
                    <div class="box-publicacion-header">
                        <div class="box-publicacion-header-user"></div>
                        User
                    </div>

                    <div class="box-publicacion-img" style="background-image: url('../../img/Fondo.png');"></div>

                    <div class="box-publicacion-footer">
                        <i class="fa-solid fa-heart" style="font-size: 25px;"></i>
                        <i class="fa-regular fa-comments" style="font-size: 25px;"></i>
                    </div>
                </div>
            </div>

            <div class="perfil">
                <div class="perfil-box">
                    <div class="perfil-header" style="background-image: url('../../img/Fondo.png');">
                    <!-- <img src="../../img/Fondo.png" alt="Fondo de perfil"> -->
                    </div>
                    <div class="perfil-foto">
                        <img src="../../img/user-icon.png" alt="Foto de perfil">
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
                            <img src="../../img/user-icon.png" alt="Foto de perfil">
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>