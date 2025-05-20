@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="eventos-main">
        <div style="display: flex; flex-direction: column; width: 100%; align-items: center; gap: 40px;">

            <div class="clase-banner">
                {{ $curso->nombre }}
                <div>
                    <img src="{{ asset('img/separador.png') }}" alt="Separador">
                </div>
            </div>

            @foreach ($contenido as $contenido)
                @if ($contenido->opcion == 0)
                    <div class="clase-box-opc-0">
                        <td>{{ $contenido->titulo }}</td>
                        <td>{{ $contenido->descripcion }}</td>
                    </div>
                @elseif ($contenido->opcion == 1)
                    <div class="clase-box-opc-1">
                        <div class="clase-box-opc-1-text">
                            <td>{{ $contenido->titulo }}</td>
                            <td>{{ $contenido->descripcion }}</td>
                        </div>
                        <div class="clase-box-opc-1-img"
                            style="background-image: url('{{ asset('storage/' . $contenido->imagen) }}'); background-size: cover; background-position: center; width: 100%; height: 200px;">
                        </div>
                    </div>
                @elseif ($contenido->opcion == 2)
                    <div class="clase-box-opc-1">
                        <div class="clase-box-opc-1-img"
                            style="background-image: url('{{ asset('storage/' . $contenido->imagen) }}'); background-size: cover; background-position: center; width: 100%; height: 200px;">
                        </div>
                        <div class="clase-box-opc-1-text">
                            <td>{{ $contenido->titulo }}</td>
                            <td>{{ $contenido->descripcion }}</td>
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="clase-descripcion">
                <div class="clase-descripcion-texto">
                    <h2>Vols estudiar el CFGM en Electromecànica de Vehicles Automòbils?
                    </h2>
                    <p>
                    Si t’agrada el món de l’automòbil i vols saber com funciona un motor de combustió, manipular un sistema de suspensió, desmuntar els engranatges i, en definitiva, aprendre tots els secrets de la mecànica, el CFGM en Electromecànica de Vehicles Automòbils és per a tu. Prepara’t per ser un mecànic de nivell capaç de reparar tot tipus d’avaries electromecàniques i treballar en qualsevol taller o concessionari oficial.
                    </p>
                    <p>
                    Cicle LOE
                    </p>
                    <p>
                    Durada: 2000 hores. (2 cursos acadèmics). Horari de tarda.
                    </p>
                    <p>
                    Família professional: Transport i manteniment de vehicles
                    </p>
                </div>
                <div class="clase-descripcion-video">
                    <iframe 
                        src="https://www.youtube.com/embed/jep61AQL2mY?modestbranding=1&rel=0" 
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe> 
                </div>
            </div>

            <div class="clase-infos">
                <div class="clase-infos-info">
                    <div class="clase-infos-info-header">
                        <i class="fa-solid fa-book"></i>
                        <h2>Què aprendràs?</h2>
                    </div> 
                    
                    <div class="clase-infos-info-body">
                        <div class="clase-infos-info-content">
                            <ul>
                                <li>Crearàs vídeojocs utilitzant dissenys 2D i 3D.</li>
                                <li>Crearàs pàgines web amb html, php, css.</li>
                                <li>Desenvoluparàs aplicacions mòbils.</li>
                                <li>Sistemas informàtics segons el seu hardware, software i la xarxa de connexió.</li>
                                <li>Desenvoluparàs aplicacions d'escriptori i d'ERP.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="clase-infos-info">
                    <div class="clase-infos-info-header">
                        <i class="fa fa-th-list" aria-hidden="true"></i>
                        <h2>Plà d'estudis</h2>
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
                                    <tr><td>Desenvolupament d’aplicacions multiplataforma</td><td>121h</td></tr>
                                    <tr><td>Desenvolupament d’aplicacions web</td><td>110h</td></tr>
                                    <tr><td>Desenvolupament d’aplicacions mòbils</td><td>187h</td></tr>
                                    <tr><td>Desenvolupament d’interfícies</td><td>77h</td></tr>
                                    <tr><td>Entorns de desenvolupament</td><td>55h</td></tr>
                                    <tr><td>Accés a dades</td><td>88h</td></tr>
                                    <tr><td>Desenvolupament d’interfícies</td><td>88h</td></tr>
                                    <tr><td>Programació multimèdia i dispositius mòbils</td><td>77h</td></tr>
                                    <tr><td>Programació de serveis i processos</td><td>55h</td></tr>
                                    <tr><td>Sistemes de gestió empresarial</td><td>55h</td></tr>
                                    <tr><td>Formació i orientació laboral</td><td>66h</td></tr>
                                    <tr><td>Empresa i iniciativa emprenedora</td><td>66h</td></tr>
                                    <tr><td>Projecte de desenvolupament d’aplicacions multiplataforma, perfil videojocs i oci digital</td><td>297h</td></tr>
                                    <tr><td>Formació en centres de treball</td><td>383h</td></tr>
                                    <tr><td>Game design</td><td>33h</td></tr>
                                    <tr><td>Disseny 2D i 3D</td><td>88h</td></tr>
                                    <tr><td>Programació de videojocs 2D i 3D</td><td>154h</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="clase-infos-info">
                    <div class="clase-infos-info-header">
                        <i class="fa-solid fa-book"></i>
                        <h2>Què aprendràs?</h2>
                    </div> 
                    
                    <div class="clase-infos-info-body">
                        <div class="clase-infos-info-content">
                            <ul>
                                <li>Crearàs vídeojocs utilitzant dissenys 2D i 3D.</li>
                                <li>Crearàs pàgines web amb html, php, css.</li>
                                <li>Desenvoluparàs aplicacions mòbils.</li>
                                <li>Sistemas informàtics segons el seu hardware, software i la xarxa de connexió.</li>
                                <li>Desenvoluparàs aplicacions d'escriptori i d'ERP.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="clase-infos-info">
                    <div class="clase-infos-info-header">
                        <i class="fa-solid fa-book"></i>
                        <h2>Què aprendràs?</h2>
                    </div> 
                    
                    <div class="clase-infos-info-body">
                        <div class="clase-infos-info-content">
                            <ul>
                                <li>Crearàs vídeojocs utilitzant dissenys 2D i 3D.</li>
                                <li>Crearàs pàgines web amb html, php, css.</li>
                                <li>Desenvoluparàs aplicacions mòbils.</li>
                                <li>Sistemas informàtics segons el seu hardware, software i la xarxa de connexió.</li>
                                <li>Desenvoluparàs aplicacions d'escriptori i d'ERP.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="clase-infos-info">
                    <div class="clase-infos-info-header">
                        <i class="fa-solid fa-book"></i>
                        <h2>Què aprendràs?</h2>
                    </div> 
                    
                    <div class="clase-infos-info-body">
                        <div class="clase-infos-info-content">
                            <ul>
                                <li>Crearàs vídeojocs utilitzant dissenys 2D i 3D.</li>
                                <li>Crearàs pàgines web amb html, php, css.</li>
                                <li>Desenvoluparàs aplicacions mòbils.</li>
                                <li>Sistemas informàtics segons el seu hardware, software i la xarxa de connexió.</li>
                                <li>Desenvoluparàs aplicacions d'escriptori i d'ERP.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="clase-infos-info">
                    <div class="clase-infos-info-header">
                        <i class="fa-solid fa-book"></i>
                        <h2>Què aprendràs?</h2>
                    </div> 
                    
                    <div class="clase-infos-info-body">
                        <div class="clase-infos-info-content">
                            <ul>
                                <li>Crearàs vídeojocs utilitzant dissenys 2D i 3D.</li>
                                <li>Crearàs pàgines web amb html, php, css.</li>
                                <li>Desenvoluparàs aplicacions mòbils.</li>
                                <li>Sistemas informàtics segons el seu hardware, software i la xarxa de connexió.</li>
                                <li>Desenvoluparàs aplicacions d'escriptori i d'ERP.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; width: 100%; align-items: center;">
                <div class="clase-posts-separador">
                    <i class="fa fa-th" aria-hidden="true"></i>
                </div>
                <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
                    <div class="clase-posts">
                        @if (!empty($publicaciones) && $publicaciones->isNotEmpty())
                            @include('layouts.publicacion-grid', ['publicaciones' => $publicaciones])
                        @else
                            <div style="grid-column: 1 / -1; display: flex; justify-content: center; align-items: center;">
                                <p class="text-muted ms-2 mt-3 text-center">No hay publicaciones disponibles.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    
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
    
    @include('layouts.footer')
</body>

    <!--
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalles del Curso</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #333; }
        .campo { margin-bottom: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>

    <h1>Detalles del curso: {{ $curso->nombre }}</h1>

    <div class="campo"><span class="label">Nivel educativo:</span> {{ $curso->nivelEducativo->nombre }}</div>
    <div class="campo"><span class="label">Duración:</span> {{ $curso->duracion ?? 'No especificada' }}</div>
    <div class="campo"><span class="label">Posibilidades de continuidad:</span><br> {{ $curso->posibilidades_continuidad ?? 'No especificadas' }}</div>
    <div class="campo"><span class="label">Sector profesional:</span> {{ $curso->sector_profesional ?? 'No especificado' }}</div>
    <div class="campo"><span class="label">Salidas profesionales:</span><br> {{ $curso->salidas_profesionales ?? 'No especificadas' }}</div>
    <div class="campo"><span class="label">Prácticas en empresas:</span> {{ $curso->practicas_en_empresas ? 'Sí' : 'No' }}</div>

    @if ($curso->asignaturas_pdf)
        <div class="campo">
            <span class="label">Asignaturas principales:</span>
            <a href="{{ asset('storage/' . $curso->asignaturas_pdf) }}" target="_blank">Ver PDF</a>
        </div>
    @endif

    <div class="campo">
        <span class="label">Imágenes:</span><br>
        @forelse($curso->fotos as $foto)
            <img src="{{ asset('storage/' . $foto->ruta_imagen) }}" alt="Imagen del curso" width="150" style="margin: 10px;">
        @empty
            <p>No hay imágenes disponibles.</p>
        @endforelse
    </div>

    <a href="{{ route('niveles.index') }}">← Volver al listado de cursos</a>

</body>
</html>
-->