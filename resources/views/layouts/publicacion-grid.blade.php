                            @foreach ($publicaciones as $publicacion)
                                @php
                                    $tieneFotos = $publicacion->fotos->count() > 0;
                                    $tieneVideos = $publicacion->videos->count() > 0;
                                @endphp

                                @if ($tieneFotos || $tieneVideos)
                                    {{-- Mostrar fotos --}}
                                    @foreach ($publicacion->fotos as $foto)
                                        <div class="clase-posts-post">
                                            <img src="{{ asset('storage/publicaciones/' . $foto->ruta_foto) }}" alt="Imagen publicación" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    @endforeach

                                    {{-- Mostrar videos --}}
                                    @foreach ($publicacion->videos as $video)
                                        <div class="clase-posts-post">
                                            <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;">
                                                <source src="{{ asset('storage/publicvideos/' . $video->ruta_video) }}" type="video/mp4">
                                            </video>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Mostrar imagen por defecto --}}
                                    <div class="clase-posts-post">
                                        <img src="{{ asset('img/Fondo.png') }}" alt="Sin contenido" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @endif
                                
                            @endforeach
                        