@include('layouts.head')

<div class="misgrupos-der-header">
    <img src="../../img/user-icon.png" alt="Grupo">
    <h1>Nombre del Grupo</h1>
</div>

<div class="misgrupos-der-chat">        
    {{-- Mensaje Emisor --}}
    <div class="mis-grupos-mensajes-container emisor">
        <div class="mis-grupos-mensaje-emisor">
            @for ($i = 0; $i < 15; $i++)
                <div class="mensaje-burbuja">
                    <p>Todo bien, ¿y tú?</p>
                    <span class="mensaje-hora mhe">10:32</span>
                </div>
            @endfor
        </div>
                    
        <div class="mensaje-perfil">
            <img src="../../img/user-icon.png" alt="Perfil">
        </div>
    </div>

    {{-- Mensaje Receptor --}}
    <div class="mis-grupos-mensajes-container receptor">
        <div class="mensaje-perfil">
            <img src="../../img/user-icon.png" alt="Perfil">
        </div>
                
        <div class="mis-grupos-mensaje-receptor">
            @foreach($publicaciones as $publicacion)
                <div class="mensaje-burbuja">
                    <p>{{ $publicacion->descripcion }}</p>
                    @if($publicacion->fotos->count())
                        <div class="mensaje-burbuja-fotos">
                            @foreach($publicacion->fotos as $foto)
                                <img src="{{ asset('storage/' . $foto->ruta_foto) }}" alt="Foto de publicación">
                            @endforeach
                        </div>
                    @else
                        <p>No hay fotos adjuntas.</p>
                    @endif
                    <span class="mensaje-hora">{{ \Carbon\Carbon::parse($publicacion->fecha_publicacion)->format('d/m/Y H:i') }}</span>
                </div>
                <p class="mensaje-burbuja-usuario">{{ $publicacion->usuario->name }}</p>

                

                <!--
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
                @endif -->
        @endforeach
        </div>
    </div> 
</div>

<div style="padding: 10px;">
    <div class="misgrupos-der-footer">
        <button class="icon-btn">
            <i class="fa-regular fa-face-smile"></i>
        </button>
        <input
            type="text"
            placeholder="Enviar mensaje..."
            class="chat-input"
        />
        <div class="chat-icons-right">
            <button class="icon-btn" title="Audio">
                <i class="fa-solid fa-microphone"></i>
            </button>
            <button class="icon-btn" title="Imagen">
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