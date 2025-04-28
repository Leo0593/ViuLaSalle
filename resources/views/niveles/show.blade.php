@include('layouts.head')

<body>
    @include('layouts.navheader')
   
    <div class="eventos-main">
        <div style="display: flex; flex-direction: column; width: 100%; align-items: center; gap: 80px; margin-bottom: 50px;">

            <div class="clase-banner">
                CFGM en Electromecànica de Vehicles Automòbils
                <div>
                    <img src="{{ asset('img/separador.png') }}" alt="Separador">
                </div>
            </div>

            <div class="clase-descripcion">
                <div class="clase-descripcion-video">
                    <iframe 
                        src="https://www.youtube.com/embed/KFkc5DtcbIM?modestbranding=1&rel=0" 
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>                    
                </div>
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
                
            </div>


            <!--
            <div class="video-wrapper">
                <iframe 
                    src="https://www.youtube.com/embed/fOdrXsJfEuE?modestbranding=1&rel=0"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
-->
        </div>
    </div>
</body>