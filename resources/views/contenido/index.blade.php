{{-- Estilos CSS --}}
<div>
    <a href="{{ route('contenido.create') }}" style="padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px;">Crear Nuevo Contenido</a>
</div>

<h1>Listado de Contenidos</h1>

@if(session('success'))
    <div style="color:green;">{{ session('success') }}</div>
@endif

{{-- Tabla con contenidos --}}
<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Vista</th>
            <th>Vista Tipo</th>
            <th>Tipo</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Video</th>
            <th>Opción</th>
            <th>Status</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contenidos as $contenido)
        <tr>
            <td>{{ $contenido->id }}</td>
            <td>{{ $contenido->id_vista }}</td>
            <td>{{ $contenido->vista_tipo }}</td>
            <td>{{ $contenido->tipo }}</td>
            <td>{{ $contenido->titulo }}</td>
            <td>{{ \Illuminate\Support\Str::limit($contenido->descripcion, 10) }}</td>
            <td>{{ $contenido->imagen }}</td>
            <td>{{ $contenido->video }}</td>
            <td>{{ $contenido->opcion }}</td>
            <td>{{ $contenido->status }}</td>
            <td>
                <a href="{{ route('contenido.edit', $contenido->id) }}" style="padding: 5px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 5px;">Editar</a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@foreach ($contenidos as $contenido)
    @if ($contenido->tipo == 'contenedor') 
        <div class="contenido-box" style="margin-top: 20px;">
            @if($contenido->opcion == 0)
                <div class="contenido-box-opc-0">
                    <td>{{ $contenido->titulo }}</td>
                    <td>{{ $contenido->descripcion }}</td>
                </div>
            @elseif($contenido->opcion == 1)
                <div class="contenido-box-opc-1">
                    <div class="contenido-box-opc-1-text">
                        <td>{{ $contenido->titulo }}</td>
                        <td>{{ $contenido->descripcion }}</td>
                    </div>
                    <div class="contenido-box-opc-1-img"
                        style="background-image: url('{{ asset('storage/' . $contenido->imagen) }}'); background-size: cover; background-position: center; width: 100%; height: 200px;">
                    </div>
                </div>
            @elseif($contenido->opcion == 2)
                <div class="contenido-box-opc-1">
                    <div class="contenido-box-opc-1-img"
                        style="background-image: url('{{ asset('storage/' . $contenido->imagen) }}'); background-size: cover; background-position: center; width: 100%; height: 200px;">
                    </div>
                    <div class="contenido-box-opc-1-text">
                        <td>{{ $contenido->titulo }}</td>
                        <td>{{ $contenido->descripcion }}</td>
                    </div>
                </div>
            @endif
        </div>
    @endif
@endforeach

{{-- Contenidos tipo "columna" (van en grid) --}}
@php
    $columnas = $contenidos->filter(fn($c) => $c->tipo == 'columna');
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

    <script>
        document.querySelectorAll('.clase-infos-info-header').forEach(header => {
            header.addEventListener('click', () => {
                const parent = header.parentElement;
                parent.classList.toggle('active');

                // Opcional: Ajustar altura dinámicamente si el contenido es variable
                const body = parent.querySelector('.clase-infos-info-body');
                if (parent.classList.contains('active')) {
                    body.style.maxHeight = body.scrollHeight + "px";
                } else {
                    body.style.maxHeight = "0";
                    // Resetear después de la animación
                    setTimeout(() => { body.style.maxHeight = null; }, 400);
                }
            });
        }); 
    </script>