<div class="box-publicacion">
    <div class="box-publicacion-header">
        <div class="box-publicacion-header-user">
            <img src="{{ $publicacion->usuario->avatar ? Storage::url($publicacion->usuario->avatar) : asset('img/user-icon.png') }}"
                alt="Avatar usuario">
        </div>

        <div class="box-publicacion-header-name">
            {{ $publicacion->usuario->name }}
        </div>

        @if(Auth::check()) 
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
                            <button type="submit" class="btn-notif-window reportar">
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

                @if(Auth::user()->id == $publicacion->id_user)
                    <li>
                        <a class="btn-notif-window editar" href="{{ route('publicaciones.edit', $publicacion->id) }}">
                            <i class="fa fa-edit" aria-hidden="true"></i> Editar
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('publicaciones.destroy', $publicacion->id) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta publicación?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-notif-window eliminar">
                                <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                            </button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
        @endif
    </div>

    <!-- Mostrar fotos y videos -->
    @if($publicacion->fotos->count() > 0 && $publicacion->videos->count() > 0)
        <div class="box-publicacion-media-container">
            <div class="box-publicacion-media-container-media">
                <!-- Mostrar fotos -->
                @foreach($publicacion->fotos as $foto)
                    <div class="box-publicacion-media-item box-publicacion-img"
                        style="background-image: url('{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}');"></div>
                @endforeach
                <!-- Mostrar videos -->
                @foreach($publicacion->videos as $video)
                    <div class="box-publicacion-media-item box-publicacion-video">
                        <video controls loop>
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

        <!-- Mostrar fotos -->
    @elseif($publicacion->fotos->count() > 0)
        <div class="box-publicacion-img-container">
            @foreach($publicacion->fotos as $foto)
                <div class="box-publicacion-img"
                    style="background-image: url('{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}');"></div>
            @endforeach
        </div>
        @if($publicacion->fotos->count() > 1)
            <div class="dots-container">
                @foreach($publicacion->fotos as $foto)
                    <span class="dot"></span>
                @endforeach
            </div>
        @endif

        <!-- Mostrar Videos -->
    @elseif($publicacion->fotos->count() > 0)
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
        <div class="box-publicacion-img" style="background-image: url('{{ asset('../../img/Fondo.png') }}');"></div>
    @endif

    <div class="box-publicacion-footer">
        <div class="box-publicacion-buttons">
            <button class="like-btn" data-id="{{ $publicacion->id }}"
                style="background: none; border: none; cursor: pointer;">
                <i class="{{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'fa-solid' : 'fa-regular' }} fa-heart"
                    style="font-size: 25px; color: {{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'red' : 'black' }};"></i>
            </button>

            <!-- Botón de comentarios -->
            @if($publicacion->activar_comentarios == 1)
                <button class="btn-comentarios" data-id="{{ $publicacion->id }}">
                    <i class="fa-regular fa-comments"></i>
                </button>
            @endif

            @php
                $maxLength = 100;
                $descripcion = $publicacion->descripcion;
            @endphp
            <div class="descripcion">
                <span class="descripcion-publicacion-texto" onclick="toggleDescripcion(this)">
                    <strong>{{ $publicacion->usuario->name }}: </strong>
                    <span class="texto">{{ $publicacion->descripcion }}</span>
                </span>
                
                @if(strlen($descripcion) > $maxLength)
                    <span class="ver-mas" onclick="toggleDescripcion(this.previousElementSibling)">
                        ... Ver más
                    </span>
                @endif
            </div>
        </div>

        <!-- Caja de comentarios -->
        <div class="box-publicacion-comentarios" id="comentarios-{{ $publicacion->id }}">
            @if($publicacion->comentarios->isNotEmpty())
                @foreach($publicacion->comentarios as $comentario)
                    <div class="comentario">
                        <div class="box-publicacion-header-user"
                            style="margin-right: 0px; box-shadow: 0 0 0 rgba(0, 0, 0, 0); border: 0.8px solid rgb(200 200 200 / 50%);">
                            <img src="{{ $comentario->usuario->avatar ? Storage::url($comentario->usuario->avatar) : asset('img/user-icon.png') }}"
                                alt="Avatar usuario">
                        </div>

                        <strong>{{ $comentario->usuario->name ?? 'User' }}:</strong>
                        <p>{{ $comentario->contenido }}</p>
                    </div>
                @endforeach
            @else
                <div class="no-comentarios">
                    Todavía no hay comentarios aún.
                </div>
            @endif

            @if(Auth::check())
                <div>
                    <form action="{{ route('comentarios.store') }}" method="POST" class="agregar-comentario">
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
                        <input class="box-crear-publicacion-header-texto" style="padding: 10px; height: auto;" type="text"
                            name="contenido" placeholder="Escribe un comentario..." required>
                        <button class="enviar-comentario" type="submit"><i class="fa fa-paper-plane"
                                aria-hidden="true"></i></button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>




<!-- Scripts -->



<!-- Mostrar/Ocultar Comentarios 
<script>
    $(document).ready(function () {
        $('.btn-comentarios').click(function () {
            const id = $(this).data('id');
            $('#comentarios-' + id).slideToggle(); // cambia display entre none y block con animación
        });
    });
</script>-->