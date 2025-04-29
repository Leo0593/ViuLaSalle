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
        </div>
    </div>

    <!-- Mostrar fotos y videos -->
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

    <!-- Mostrar fotos -->
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

    <!-- Mostrar videos -->
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
        <div class="box-publicacion-img" style="background-image: url('{{ asset('../../img/Fondo.png') }}');"></div>
    @endif

    <div class="box-publicacion-footer">
        <div class="box-publicacion-buttons">
            <button class="like-btn" data-id="{{ $publicacion->id }}" style="background: none; border: none; cursor: pointer;">
                <i class="{{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'fa-solid' : 'fa-regular' }} fa-heart"
                    style="font-size: 25px; color: {{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'red' : 'black' }};"></i>
            </button>

            <!-- Botón de comentarios -->
            @if($publicacion->activar_comentarios == 1)
                <button class="btn-comentarios" data-id="{{ $publicacion->id }}">
                    <i class="fa-regular fa-comments"></i>
                </button>
            @endif

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
                        <div class="box-publicacion-header-user" style="margin-right: 0px; box-shadow: 0 0 0 rgba(0, 0, 0, 0); border: 0.8px solid rgb(200 200 200 / 50%);">
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
                    <form action="{{ route('comentarios.store') }}" method="POST" class="agregar-comentario">
                        @csrf
                        <div class="box-crear-publicacion-header-foto" style="margin-right: 0px; box-shadow: 0 0 0 rgba(0, 0, 0, 0); border: 0.8px solid rgb(200 200 200 / 50%);">
                            @if(Auth::check() && Auth::user()->avatar)
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar usuario" onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                            @else
                                <img src="{{ asset('img/user-icon.png') }}" alt="Avatar por defecto">
                            @endif
                        </div>

                        <input type="hidden" name="id_publicacion" value="{{ $publicacion->id }}">
                        <input class="box-crear-publicacion-header-texto" style="padding: 10px; height: auto;" type="text" name="contenido" placeholder="Escribe un comentario..." required>
                        <button class="enviar-comentario" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Scripts -->

<!-- Opciones/Reportar -->
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

<!-- Mostrar/Ocultar Comentarios 
<script>
    $(document).ready(function () {
        $('.btn-comentarios').click(function () {
            const id = $(this).data('id');
            $('#comentarios-' + id).slideToggle(); // cambia display entre none y block con animación
        });
    });
</script>-->