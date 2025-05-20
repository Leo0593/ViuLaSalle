@include('layouts.head')

<div class="misgrupos-der-header">
    <img src="../../img/user-icon.png" alt="Grupo">
    <h1>{{ $coleccion->nombre }}</h1>
</div>

<div class="misgrupos-der-chat">
    {{-- Mensaje Emisor --}}
    <div class="mis-grupos-mensajes-container">
        @foreach($publicaciones as $publicacion)
            @php
                $esMia = $publicacion->user_id === auth()->id();
            @endphp

            <div class="mensaje-burbuja {{ $esMia ? 'mensaje-emisor' : 'mensaje-receptor' }}">

                {{-- Foto de perfil (opcional) --}}
                <div class="mensaje-perfil {{ $esMia ? 'alineacion-emisor' : 'alineacion-receptor' }}">
                    <img src="../../img/user-icon.png" alt="Perfil">
                </div>

                {{-- Contenido de la burbuja --}}
                <div class="mis-grupos-mensaje-contenido">
                    {{-- Carrusel de fotos --}}
                    @if($publicacion->fotos->count())
                        <div class="mensaje-burbuja-fotos">
                            <div class="carousel-container">
                                @foreach($publicacion->fotos as $foto)
                                    <div class="carousel-slide">
                                        <div class="box-publicacion-img"
                                            style="background-image: url('{{ asset('storage/' . $foto->ruta_foto) }}');"
                                            title="Click para ampliar">
                                        </div>
                                    </div>
                                @endforeach

                                @if($publicacion->fotos->count() > 1)
                                    <button class="carousel-control prev" onclick="moveSlide(this, -1)">❮</button>
                                    <button class="carousel-control next" onclick="moveSlide(this, 1)">❯</button>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Descripción --}}
                    <div class="mensaje-descripcion">
                        <p>{{ $publicacion->descripcion }}</p>
                        <span
                            class="mensaje-hora">{{ \Carbon\Carbon::parse($publicacion->fecha_publicacion)->format('H:i') }}</span>
                    </div>

                    {{-- Botones de acción SOLO para el usuario dueño --}}
                    @if ($esMia)
                        <div class="mensaje-burbuja-acciones">
                            <a href="{{ route('publicacioncolecciones.edit', $publicacion->id) }}" class="btn btn-sm btn-info"
                                title="Editar">
                                <i class="fa-solid fa-pencil"></i>
                            </a>

                            @if ($publicacion->status)
                                <form method="POST" action="{{ route('publicacioncolecciones.destroy', $publicacion->id) }}"
                                    class="form-inline d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Desactivar"
                                        onclick="return confirm('¿Desactivar esta publicación?')">
                                        <i class="fa-solid fa-toggle-off"></i>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('publicacioncolecciones.activate', $publicacion->id) }}"
                                    class="form-inline d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success" title="Activar"
                                        onclick="return confirm('¿Activar esta publicación?')">
                                        <i class="fa-solid fa-toggle-on"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>


    <!-- Modal para imagen ampliada -->
    <div id="modalImagen" class="modal-imagen" style="display:none;">
        <span class="cerrar-modal" title="Cerrar">&times;</span>
        <div class="modal-contenedor">
            <img class="modal-contenido" id="imgAmpliada" src="">

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
</div>



<div style="padding: 10px;">
    <div class="misgrupos-der-footer">
        <button class="icon-btn">
            <i class="fa-regular fa-face-smile"></i>
        </button>
        <input type="text" placeholder="Enviar mensaje..." class="chat-input" />
        <div class="chat-icons-right">
            <button class="icon-btn" title="Audio">
                <i class="fa-solid fa-microphone"></i>
            </button>
            <button class="icon-btn" title="Crear Nueva Publicación"
                onclick="window.location='{{ route('publicacioncolecciones.create', ['coleccion_id' => $coleccion->id]) }}'">
                <i class="fa-regular fa-image"></i>
            </button>

            <button class="icon-btn" title="Reaccionar">
                <i class="fa-regular fa-heart"></i>
            </button>
        </div>
        <button class="send-btn" title="Enviar">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </div>
</div>

<script src="{{ asset(path: '/js/publicacion-modal.js') }}"></script>
<script src="{{ asset(path: '/js/carrusel-coleccion-show.js') }}"></script>
<script src="{{ asset(path: '/js/carrusel-desplegable-juntos.js') }}"></script>



<style>
    /* Contenedor general de los mensajes */
    .mis-grupos-mensajes-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 10px;
    }

    /* Burbuja de mensaje */
    .mensaje-burbuja {
        position: relative;
        display: flex;
        align-items: flex-end;
        max-width: 80%;
        border-radius: 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        background-color: #f0f0f0;
    }

    .mensaje-emisor {
        align-self: flex-end;
        flex-direction: row-reverse;
        text-align: right;
    }

    .mensaje-receptor {
        align-self: flex-start;
        text-align: left;
    }

    /* Contenido del mensaje */
    .mis-grupos-mensaje-contenido {
        background-color: #e2f0ff;
        padding: 10px;
        border-radius: 12px;
        max-width: 100%;
        position: relative;
    }

    .mensaje-emisor .mis-grupos-mensaje-contenido {
        background-color: #d1ffe2;
    }

    /* Descripción y hora */
    .mensaje-descripcion {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e0e0e0;
    }

    .mensaje-descripcion p {
        margin: 0;
        font-size: 14px;
    }

    .mensaje-hora {
        display: block;
        font-size: 0.75rem;
        color: #666;
        margin-top: 5px;
        text-align: right;
    }

    /* Imagen de perfil */
    .mensaje-perfil {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        margin-left: 10px;
    }

    .mensaje-perfil img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .alineacion-emisor {
        margin-left: auto;
    }

    /* Carrusel */
    .carousel-container {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 8px;
    }

    .carousel-slide {
        display: none;
        width: 100%;
        transition: transform 0.5s ease;
    }

    .carousel-slide.active {
        display: block;
    }

    .box-publicacion-img {
        width: 100%;
        height: 300px;
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        cursor: pointer;
    }

    /* Carrusel controles */
    .carousel-control {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        font-size: 16px;
        cursor: pointer;
        z-index: 10;
    }

    .carousel-control.prev {
        left: 10px;
    }

    .carousel-control.next {
        right: 10px;
    }

    /* Botones de acción */
    .mensaje-burbuja-acciones {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        flex-direction: column;
        /* <-- Añadido */
        gap: 5px;
        z-index: 5;
        gap: 8px;
    }


    .mensaje-burbuja-acciones a.btn,
    .mensaje-burbuja-acciones button.btn {
        padding: 5px 8px;
        font-size: 0.85rem;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    form.form-inline {
        margin: 0;
    }

    /* Colores de botones */
    .btn-info {
        background-color: #17a2b8;
    }

    .btn-info:hover {
        background-color: #138496;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning {
        background-color: #ffc107;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }
</style>