@include('layouts.head')

<body>
    @include('layouts.navheader')
   
    <div class="eventos-main">
        <div style="display: flex; flex-direction: column; width: 100%; align-items: center; gap: 40px;">

            <!--
            <div style="width: 90%; gap 40px;">
                <div  style="aspect-ratio: 16/9; width: 100%;">
                    <iframe 
                        src="https://www.youtube.com/embed/jep61AQL2mY?modestbranding=1&rel=0" 
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        style="width: 100%; height: 100%; display: block;">
                    </iframe> 
                </div>
                
                CFGS Desenvolupament d’aplicacions multiplataforma, perfil professional Videojocs i oci digital
                <div>
                    <img src="{{ asset('img/separador.png') }}" alt="Separador">
                </div>
            
                <div>
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
            </div> -->
            <div class="clase-banner">
                CFGS Desenvolupament d’aplicacions multiplataforma, perfil professional Videojocs i oci digital
                <div>
                    <img src="{{ asset('img/separador.png') }}" alt="Separador">
                </div>
            </div>

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
                        <!--
                        @for ($i = 0; $i < 5; $i++)
                            <div class="clase-posts-post">
                                <img src="{{ asset('../../img/bp1.jpg') }}" alt="Portada">
                            </div>
                        @endfor -->

                        @if (!empty($publicaciones) && $publicaciones->isNotEmpty())
                            @include('layouts.publicacion-grid', ['publicaciones' => $publicaciones])
                        @else
                            <p>No hay publicaciones disponibles.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">


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