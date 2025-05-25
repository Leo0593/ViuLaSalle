@foreach ($contenidos as $contenido)
                @if ($contenido->tipo == 'contenedor')
                    <div class="eventos-main-contenidos">
                        @if ($contenido->opcion == 0)
                            <div class="contenido-box-opc-0">
                                <div class="contenido-box-opc-1-text">
                                    <h1>{{ $contenido->titulo }}</h1>
                                    @foreach(explode("\n", $contenido->descripcion) as $linea)
                                        <p>{{ $linea }}</h1>
                                    @endforeach
                                </div>
                                @if ($contenido->imagen != null) 
                                        <div class="contenido-box-opc-0-img">
                                            <img src="{{ asset('storage/' . $contenido->imagen) }}" alt="{{ $contenido->titulo }}">
                                        </div>
                                @elseif ($contenido->video != null)
                                    @php
                                        $videoId = null;
                                        if (preg_match('/(?:\?v=|\/embed\/|\.be\/)([a-zA-Z0-9_-]+)/', $contenido->video, $matches)) {
                                            $videoId = $matches[1];
                                        }
                                    @endphp

                                    @if ($videoId)
                                        <div class="contenido-box-opc-1-video">
                                            <iframe 
                                                src="https://www.youtube.com/embed/{{ $videoId }}"                                         frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe> 
                                        </div>
                                    @endif
                                @endif  
                            </div>
                        @elseif ($contenido->opcion == 1)
                            <div class="contenido-box-opc-1">
                                <div class="contenido-box-opc-1-text">
                                    <h1>{{ $contenido->titulo }}</h1>
                                    <p>{{ $contenido->descripcion }}</h1>
                                </div>

                                @if ($contenido->imagen != null) 
                                    <div class="contenido-box-opc-1-img"
                                        style="background-image: url('{{ asset('storage/' . $contenido->imagen) }}');">
                                    </div>
                                @elseif ($contenido->video != null)
                                    @php
                                        $videoId = null;
                                        if (preg_match('/(?:\?v=|\/embed\/|\.be\/)([a-zA-Z0-9_-]+)/', $contenido->video, $matches)) {
                                            $videoId = $matches[1];
                                        }
                                    @endphp

                                    @if ($videoId)
                                        <div class="contenido-box-opc-1-video">
                                            <iframe 
                                                src="https://www.youtube.com/embed/{{ $videoId }}"                                         frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe> 
                                        </div>
                                    @endif
                                @endif  
                            </div>
                        @elseif ($contenido->opcion == 2)
                            <div class="contenido-box-opc-1">
                                    @if ($contenido->imagen != null) 
                                        <div class="contenido-box-opc-1-img"
                                            style="background-image: url('{{ asset('storage/' . $contenido->imagen) }}');">
                                        </div>
                                    @elseif ($contenido->video != null)
                                        @php
                                            $videoId = null;
                                            if (preg_match('/(?:\?v=|\/embed\/|\.be\/)([a-zA-Z0-9_-]+)/', $contenido->video, $matches)) {
                                                $videoId = $matches[1];
                                            }
                                        @endphp

                                        @if ($videoId)
                                            <div class="contenido-box-opc-1-video">
                                                <iframe 
                                                    src="https://www.youtube.com/embed/{{ $videoId }}"                                         frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                                </iframe> 
                                            </div>
                                        @endif
                                    @endif  
                                <div class="contenido-box-opc-1-text">
                                    <h1>{{ $contenido->titulo }}</h1>
                                    <p>{{ $contenido->descripcion }}</h1>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach

            {{-- Contenidos tipo "columna" (van en grid) --}}
            @php
                $columnas = $contenidos->filter(fn($c) => $c->tipo == 'columna')->values();
                $count = $columnas->count();            
            @endphp

            @if($columnas->count())
                <div class="clase-infos">
                    @foreach ($contenidos as $contenido)
                        @if ($contenido->tipo == 'columna')
                            @if($contenido->opcion == 0)
                                <div class="clase-infos-info">
                                    <div class="clase-infos-info-header">
                                        <h2>{{ $contenido->titulo }}</h2>
                                    </div>
                                    <div class="clase-infos-info-body">
                                        <div class="clase-infos-info-content">
                                            <ul>
                                                @foreach(explode("\n", $contenido->descripcion) as $linea)
                                                    <li>{{ $linea }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @elseif($contenido->opcion == 1)
                                <div class="clase-infos-info">
                                    <div class="clase-infos-info-header">
                                        <h2>{{ $contenido->titulo }}</h2>
                                    </div>
                                    <div class="clase-infos-info-body">
                                        <div class="clase-infos-info-content">
                                        <table class="moduls-table">
                                            <thead>
                                                <tr>
                                                    <th>Mòduls professionals</th>
                                                    <th>Durada (h)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(preg_split('/\r\n|\r|\n/', $contenido->descripcion) as $linea) 
                                                    @php
                                                        // Dividimos por tabuladores o por 2+ espacios
                                                        $partes = preg_split('/\t+|\s{2,}/', trim($linea));
                                                    @endphp
                                                    @if(count($partes) === 2)
                                                        <tr>
                                                            <td>{{ $partes[0] }}</td>
                                                            <td>{{ $partes[1] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            @endif