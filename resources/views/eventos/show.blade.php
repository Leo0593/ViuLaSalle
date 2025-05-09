@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div>
        <div id="banner" class="evento-banner" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0)), url('{{ Storage::url($evento->foto) }}');"
            data-aos="zoom-in" data-aos-duration="1000">
        </div>

        <div class="evento-header">
            <nav class="nav">
                <a class="nav-link" href="#banner">BANNER</a>
                <a class="nav-link" href="#info">INFO</a>
                <a class="nav-link" href="#posts">POSTS</a>
            </nav>
        </div>

        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; margin-bottom: 30px;">
            <div class="main-evento">
                <div id="info"
                    data-aos="zoom-in" data-aos-duration="1000"
                    class="box-evento"
                    style="scroll-margin-top: 110px;">

                        <div class="eventos-title-container">
                            <h2 class="eventos-title">INFO</h2>
                        </div>

                        <div class="evento-info">
                            <div class="evento-descripcion"> 
                                <div class="calendar">
                                    <div class="calendar-header">Ene.</div>
                                    <div class="calendar-body">30</div>
                                </div>
                                <div class="descripcion-texto">
                                    <p>
                                        Navidad Solidaria es una iniciativa que busca fomentar la generosidad y el espíritu de ayuda durante las fiestas navideñas. Se trata de realizar acciones solidarias, como donar ropa, juguetes, alimentos o tiempo a quienes más lo necesitan. Muchas organizaciones, empresas y grupos comunitarios organizan eventos benéficos, campañas de recolección y actividades para apoyar a personas en situación de vulnerabilidad.
                                        El objetivo de una Navidad Solidaria es compartir más allá de los regalos materiales, promoviendo valores como la empatía, la unión y la gratitud. Puede incluir desde visitas a hospitales y hogares de ancianos hasta cenas comunitarias o apadrinamiento de niños en riesgo de exclusión social.
                                        En esencia, se trata de recordar que el verdadero significado de la Navidad no está solo en la celebración, sino en hacer que todos puedan vivir estas fechas con alegría y esperanza.
                                    </p>
                                </div>
                            </div>

                            <div class="evento-imagen" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0)), url('{{ Storage::url($evento->foto) }}');">
                            </div>
                        </div>
                </div>
            </div>
        </div>

        @php
            $hayPublicaciones = false;
        @endphp
        <div id="posts" class="evento-posts">
            @if(isset($publicaciones) && $publicaciones->isNotEmpty())
                @foreach ($publicaciones as $publicacion)
                    @if($publicacion->id_evento == $evento->id)
                        @php
                            $hayPublicaciones = true;
                        @endphp
                        <div class="post">
                            @include('layouts.publicacion', ['publicacion' => $publicacion])     
                        </div>
                    @endif
                @endforeach
            @endif

            @if (!$hayPublicaciones)
                <div class="center-text">
                    <p>No hay publicaciones disponibles.</p>
                </div>
            @endif
        </div>
    </div>

    @include('layouts.footer')

    <!-- Script DOTS -->
    <script src="{{ asset('/js/dots.js') }}"></script>
</body>