@include('layouts.head')

<div class="misgrupos-der-header">
    <img src="../../img/user-icon.png" alt="Grupo">
    <h1>{{ $coleccion->nombre }}</h1>
</div>

<div class="misgrupos-der-chat">
    {{-- Mensaje Emisor --}}
    <div class="mis-grupos-mensajes-container emisor">
        @foreach($publicaciones as $publicacion)
            @if ($publicacion->user_id == auth()->user()->id)
                <div class="mensaje-burbuja">
                    <div class="mis-grupos-mensaje-emisor">
                        <p>{{ $publicacion->descripcion }}</p>

                        @if($publicacion->fotos->count())
                            <div class="mensaje-burbuja-fotos">
                                @foreach($publicacion->fotos as $foto)
                                    <div class="box-publicacion-img"
                                        style="background-image: url('{{ asset('storage/' . $foto->ruta_foto) }}');"
                                        title="Click para ampliar">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <span
                            class="mensaje-hora alineacion-emisor">{{ \Carbon\Carbon::parse($publicacion->fecha_publicacion)->format('H:i') }}</span>
                    </div>

                    <!-- Contenedor para botones -->
                    <div class="mensaje-burbuja-acciones alineacion-emisor">
                        <a href="{{ route('publicacioncolecciones.edit', $publicacion->id) }}"
                            class="btn btn-sm btn-info">Editar</a>

                        @if ($publicacion->status)
                            <form method="POST" action="{{ route('publicacioncolecciones.destroy', $publicacion->id) }}"
                                class="form-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Desactivar esta publicación?')">Desactivar</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('publicacioncolecciones.activate', $publicacion->id) }}"
                                class="form-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success"
                                    onclick="return confirm('¿Activar esta publicación?')">Activar</button>
                            </form>
                        @endif
                    </div>
                </div>


                <div class="mensaje-perfil alineacion-emisor">
                    <img src="../../img/user-icon.png" alt="Perfil">
                </div>
            @endif
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
    <script src="{{ asset(path: '/js/publicacion-modal.js') }}">
        
    </script>
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
</div>
</div>

<style>
    .box-publicacion-img {
        width: 120px;
        /* Ajusta tamaño */
        height: 90px;
        /* Ajusta tamaño */
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        cursor: pointer;
        margin: 5px;
        display: inline-block;
    }

    .mensaje-burbuja-acciones {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        /* Espacio entre botones */
        flex-wrap: wrap;
        /* Para que no se desborden en pantallas pequeñas */
        align-items: center;
    }

    .mensaje-burbuja-acciones a.btn,
    .mensaje-burbuja-acciones button.btn {
        padding: 5px 12px;
        font-size: 0.85rem;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        color: white;
        transition: background-color 0.2s ease;
    }

    /* Colores de botón (puedes ajustar a tu tema) */
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

    /* Para que los formularios no generen margen extra */
    form.form-inline {
        margin: 0;
    }
</style>
<!-- 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicaciones del Anuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .publicacion {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .fotos {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .fotos img {
            max-width: 200px;
            border-radius: 4px;
        }

        .usuario {
            font-weight: bold;
        }

        .fecha {
            color: gray;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <h1>Publicaciones del Anuario ASDASDASDSA</h1>
    <h1>Publicaciones de la colección: {{ $coleccion->nombre }}</h1>

    <a href="{{ route('publicacioncolecciones.create', ['coleccion_id' => $coleccion->id]) }}"
        class="btn btn-primary mb-4">
        <i class="fa-solid fa-plus"></i> Crear Nueva Publicación
    </a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @foreach($publicaciones as $publicacion)
        <div class="publicacion">

            <p class="usuario">Publicado por: {{ $publicacion->usuario->name }}</p>
            <p class="fecha">Fecha: {{ \Carbon\Carbon::parse($publicacion->fecha_publicacion)->format('d/m/Y H:i') }}</p>
            <p>{{ $publicacion->descripcion }}</p>

            @if($publicacion->fotos->count())
                <div class="fotos">
                    @foreach($publicacion->fotos as $foto)
                        <img src="{{ asset('storage/' . $foto->ruta_foto) }}" alt="Foto de publicación">
                    @endforeach
                </div>
            @else
                <p>No hay fotos adjuntas.</p>
            @endif

            <a href="{{ route('publicacioncolecciones.edit', $publicacion->id) }}" class="btn btn-sm btn-info">Editar</a>

            @if ($publicacion->status)
                <form method="POST" action="{{ route('publicacioncolecciones.destroy', $publicacion->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                        onclick="return confirm('¿Desactivar esta publicación?')">Desactivar</button>
                </form>
            @else
                <form method="POST" action="{{ route('publicacioncolecciones.activate', $publicacion->id) }}">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-sm btn-success"
                        onclick="return confirm('¿Activar esta publicación?')">Activar</button>
                </form>
            @endif
        </div>
    @endforeach

</body>

</html> -->