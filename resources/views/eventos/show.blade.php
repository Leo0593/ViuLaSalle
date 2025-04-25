@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div>
        <div id="banner" class="evento-banner" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0)), url('{{ Storage::url($evento->foto) }}');"
            data-aos="zoom-in" data-aos-duration="1000">
        </div>

        <div class="evento-header">
            <nav class="nav">
                <a class="nav-link" href="#banner">BANNER</a>
                <a class="nav-link" href="#info">INFO</a>
                <a class="nav-link" href="#posts">POSTS</a>
            </nav>
        </div>

        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; margin-bottom: 30px;">
            <div class="main-evento">
                <div id="info"
                    data-aos="zoom-in" data-aos-duration="1000"
                    class="box-evento"
                    style="scroll-margin-top: 110px;">

                        <div class="eventos-title-container">
                            <h2 class="eventos-title">INFO</h2>
                        </div>

                        <div class="evento-info">
                            <div class="evento-descripcion"> 
                                <div class="calendar">
                                    <div class="calendar-header">Ene.</div>
                                    <div class="calendar-body">30</div>
                                </div>
                                <div class="descripcion-texto">
                                    <p>
                                        Navidad Solidaria es una iniciativa que busca fomentar la generosidad y el espíritu de ayuda durante las fiestas navideñas. Se trata de realizar acciones solidarias, como donar ropa, juguetes, alimentos o tiempo a quienes más lo necesitan. Muchas organizaciones, empresas y grupos comunitarios organizan eventos benéficos, campañas de recolección y actividades para apoyar a personas en situación de vulnerabilidad.
                                        El objetivo de una Navidad Solidaria es compartir más allá de los regalos materiales, promoviendo valores como la empatía, la unión y la gratitud. Puede incluir desde visitas a hospitales y hogares de ancianos hasta cenas comunitarias o apadrinamiento de niños en riesgo de exclusión social.
                                        En esencia, se trata de recordar que el verdadero significado de la Navidad no está solo en la celebración, sino en hacer que todos puedan vivir estas fechas con alegría y esperanza.
                                    </p>
                                </div>
                            </div>

                            <div class="evento-imagen" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0)), url('{{ Storage::url($evento->foto) }}');">
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div id="posts" class="evento-posts">
            @if(isset($publicaciones) && $publicaciones->isNotEmpty())
                @foreach ($publicaciones as $publicacion)
                    @if($publicacion->id_evento == $evento->id)
                    <div class="post">
                        <div class="box-publicacion">
                            <div class="box-publicacion-header">
                                <div class="box-publicacion-header-user">
                                    <img src="{{ $publicacion->usuario->avatar ? Storage::url($publicacion->usuario->avatar) : asset('img/user-icon.png') }}" alt="Avatar usuario">
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

                                                    <!-- Botón de comentarios -->
                                                    <button class="btn-comentarios" data-id="{{ $publicacion->id }}">
                                                        <i class="fa-regular fa-comments"></i>
                                                    </button>

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
                                                                    <img src="{{ $comentario->usuario->avatar ? Storage::url($comentario->usuario->avatar) : asset('img/user-icon.png') }}" alt="Avatar usuario">
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
                    </div>

                    @else
                        <p>No hay publicaciones disponibles para este evento.</p>
                    @endif
                @endforeach
                @else
                    <p>No hay publicaciones disponibles.</p>
                @endif
        </div>
    </div>

    @include('layouts.footer')

    <!-- Script DOTS -->
    <script src="{{ asset('/js/dots.js') }}"></script>
</body>