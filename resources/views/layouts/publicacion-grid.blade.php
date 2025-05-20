@foreach ($publicaciones as $publicacion)
    @php
        $tieneFotos = $publicacion->fotos->count() > 0;
        $tieneVideos = $publicacion->videos->count() > 0;
    @endphp

    @if ($tieneFotos)
        {{-- Mostrar solo la primera imagen --}}
        @php $foto = $publicacion->fotos->first(); @endphp
        <div class="clase-posts-post box-publicacion-img" style="background-image: url('{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}'); ">
            <img src="{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}" alt="Foto de publicación" style="width: 100%; height: 100%; object-fit: cover;">

            {{-- Ícono en la esquina superior derecha --}}
            <span class="icon-overlay">
                @if ($publicacion->fotos->count() > 1)
                    <i class="fa fa-clone"></i> {{-- Múltiples imágenes --}}
                @else
                    <i class="fa fa-image"></i> {{-- Una imagen --}}
                @endif
            </span>
        </div>

    @elseif ($tieneVideos)
        {{-- Mostrar solo el primer video --}}
        @php $video = $publicacion->videos->first(); @endphp
        <div class="clase-posts-post">
            <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;">
                <source src="{{ asset('storage/publicvideos/' . $video->ruta_video) }}" type="video/mp4">
            </video>

            {{-- Ícono de video --}}
            <span class="icon-overlay">
                <i class="fa fa-play-circle"></i>
            </span>
        </div>
    @else
        {{-- Mostrar imagen por defecto --}}
        <div class="clase-posts-post">
            <img src="{{ asset('img/Fondo.png') }}" alt="Sin contenido" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    @endif
@endforeach
