@include('layouts.head')

<body>
    @include('layouts.navheader')
   
    <div class="eventos-main">
        <div style="display: flex; flex-direction: column; width: 100%; align-items: center; gap: 40px;">

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
                        <ul>
                            <li>Crearàs vídeojocs utilitzant dissenys 2D i 3D.</li>
                            <li>Crearàs pàgines web amb html, php, css.</li>
                            <li>Desenvoluparàs aplicacions mòbils.</li>
                            <li>Sistemas informàtics segons el seu hardware, software i la xarxa de connexió.</li>
                            <li>Desenvoluparàs aplicacions d'escriptori i d'ERP.</li>
                        </ul>
                    </div>
                </div>

                <div class="clase-infos-info">
                    <div class="clase-infos-info-header">
                        <i class="fa fa-th-list" aria-hidden="true"></i>
                        <h2>Plà d'estudis</h2>
                    </div> 
                    
                    <div class="clase-infos-info-body">
                        <ul>
                            <li>Mòduls professionals --- Durada (h)</li>
                            <li>Desenvolupament d’aplicacions multiplataforma --- 121h</li>
                            <li>Desenvolupament d’aplicacions web --- 110h</li>
                            <li>Desenvolupament d’aplicacions mòbils --- 187h</li>
                            <li>Desenvolupament d’interfícies --- 77h</li>
                            <li>Entorns de desenvolupament --- 55h</li>
                            <li>Accés a dades --- 88h</li>
                            <li>Desenvolupament d’interfícies --- 88h</li>
                            <li>Programació multimèdia i dispositius mòbils --- 77h</li>
                            <li>Programació de serveis i processos --- 55h</li>
                            <li>Sistemes de gestió empresarial --- 55h</li>
                            <li>Formació i orientació laboral --- 66h</li>
                            <li>Empresa i iniciativa emprenedora --- 66h</li>
                            <li>Projecte de desenvolupament d’aplicacions multiplataforma, perfil videojocs i oci digital --- 297h</li>
                            <li>Formació en centres de treball --- 383h</li>
                            <li>Game design --- 33h</li>
                            <li>Disseny 2D i 3D --- 88h</li>
                            <li>Programació de videojocs 2D i 3D --- 154h</li>
                        </ul>
                    </div>
                </div>

                <div class="clase-infos-info">
                    <div class="clase-infos-info-header">
                        <i class="fa-solid fa-book"></i>
                        <h2>Què aprendràs?</h2>
                    </div> 
                    
                    <div class="clase-infos-info-body">
                        <ul>
                            <li>Crearàs vídeojocs utilitzant dissenys 2D i 3D.</li>
                            <li>Crearàs pàgines web amb html, php, css.</li>
                            <li>Desenvoluparàs aplicacions mòbils.</li>
                            <li>Sistemas informàtics segons el seu hardware, software i la xarxa de connexió.</li>
                            <li>Desenvoluparàs aplicacions d'escriptori i d'ERP.</li>
                        </ul>
                    </div>
                </div>

                <div class="clase-infos-info">
                    <div class="clase-infos-info-header">
                        <i class="fa-solid fa-book"></i>
                        <h2>Què aprendràs?</h2>
                    </div> 
                    
                    <div class="clase-infos-info-body">
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
    </div>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    @include('layouts.footer')
</body>