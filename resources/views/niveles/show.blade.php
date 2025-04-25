@include('layouts.head')

<body>
    @include('layouts.navheader')
   
    <div class="eventos-main">
        <div style="display: flex; flex-direction: column; width: 100%; align-items: center;">

            <div class="clase-banner">
                CFGM en Electromecànica de Vehicles Automòbils

                <div>
                    <img src="{{ asset('img/separador.png') }}" alt="Separador">
                </div>
            </div>

            asdas

            <div class="video-wrapper">
                <iframe 
                    src="https://www.youtube.com/embed/fOdrXsJfEuE" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>

        </div>
    </div>
</body>