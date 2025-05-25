@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div>
        <div id="banner" class="evento-banner"
            style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0)), url('{{ Storage::url($evento->foto) }}');"
            data-aos="zoom-in" data-aos-duration="1000">
        </div>

        <div class="evento-header">
            <nav class="nav">
                <a class="nav-link" href="#banner">BANNER</a>
                <a class="nav-link" href="#info">INFO</a>
                <a class="nav-link" href="#posts">POSTS</a>
            </nav>
        </div>

        <div style="display: flex; flex-direction: column; width: 100%; align-items: center; gap: 40px; margin: 30px 0;">
            @include('layouts.contenido')
        </div>

        <!--
        <div
            style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; margin-bottom: 30px;">
            <div class="main-evento">
                <div id="info" data-aos="zoom-in" data-aos-duration="1000" class="box-evento">

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
                                    Navidad Solidaria es una iniciativa que busca fomentar la generosidad y el espíritu
                                    de ayuda durante las fiestas navideñas. Se trata de realizar acciones solidarias,
                                    como donar ropa, juguetes, alimentos o tiempo a quienes más lo necesitan. Muchas
                                    organizaciones, empresas y grupos comunitarios organizan eventos benéficos, campañas
                                    de recolección y actividades para apoyar a personas en situación de vulnerabilidad.
                                    El objetivo de una Navidad Solidaria es compartir más allá de los regalos
                                    materiales, promoviendo valores como la empatía, la unión y la gratitud. Puede
                                    incluir desde visitas a hospitales y hogares de ancianos hasta cenas comunitarias o
                                    apadrinamiento de niños en riesgo de exclusión social.
                                    En esencia, se trata de recordar que el verdadero significado de la Navidad no está
                                    solo en la celebración, sino en hacer que todos puedan vivir estas fechas con
                                    alegría y esperanza.
                                </p>
                            </div>
                        </div>

                        <div class="evento-imagen"
                            style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0)), url('{{ Storage::url($evento->foto) }}');">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->

        @php
            $hayPublicaciones = false;
        @endphp
        <div id="posts"  style="display: flex; flex-direction: column; width: 100%; align-items: center;">
            <div class="clase-posts-separador">
                 <i class="fa fa-th" aria-hidden="true"></i>
            </div>

            <div class="evento-posts">
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
                    <div class="no-publicaciones">
                            <!--
                            <i class="fa-solid fa-circle-exclamation"></i>-->
                        <img src="{{ asset('img/jammo-dead-ic.png') }}" alt="No hay publicaciones">
                        <p>No hay publicaciones disponibles para este evento.</p>
                    </div>
                @endif
            </div>
        </div>
        
    </div>

    <!-- Modal para imagen ampliada -->
    <div id="modalImagen" class="modal-imagen" style="display:none;">
        <span class="cerrar-modal" title="Cerrar">&times;</span>
        <div class="modal-contenedor">
            <img class="modal-contenido" id="imgAmpliada">

            <div class="modal-acciones">
                @auth
                    @if(auth()->user())
                        <a id="btnDescargarImagen" class="btn-descargar" href="#" target="_blank" title="Descargar imagen">
                            <i class="icono-descarga"></i> Descargar
                        </a>
                    @endif
                @endauth

                <button id="btnCancelar" class="btn-cancelar" title="Cerrar">
                    <i class="icono-cancelar"></i> Cancelar
                </button>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <!-- Script DOTS -->
    <script src="{{ asset('/js/dots.js') }}"></script>
    <script src="{{ asset('/js/reportes.js') }}"></script>
    <script src="{{ asset('/js/publicacion-modal.js') }}"></script>
    <!-- Script para mostrar/ocultar comentarios -->
    <script src="{{ asset('/js/mostrar-comentarios.js') }}"></script>

    <!-- Like/Dislike -->
    <script>
        $(document).ready(function () {
            $('.like-btn').click(function () {
                let button = $(this);
                let icon = button.find('i');
                let publicacionId = button.data('id');

                $.ajax({
                    url: '/publicaciones/' + publicacionId + '/like',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // Actualizar contador
                        button.siblings('.like-count').text(response.likes);

                        // Cambiar clase del ícono
                        if (response.liked) {
                            icon.removeClass('fa-regular').addClass('fa-solid').css('color', 'red');
                        } else {
                            icon.removeClass('fa-solid').addClass('fa-regular').css('color', 'black');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        function toggleDescripcion(element) {
            const container = element.closest('.box-publicacion-buttons'); // contenedor padre
            const isExpanded = element.classList.toggle('expanded'); // togglear clase expanded al texto
            
            // Cambiar clase al contenedor para ajustar alineación
            if (isExpanded) {
                container.classList.add('expanded');  // para que los botones se alineen arriba
            } else {
                container.classList.remove('expanded'); // para que vuelvan a centrarse
            }

            // Cambiar texto de "Ver más" / "Ver menos"
            const verMas = element.nextElementSibling;
            if (verMas) {
                verMas.textContent = isExpanded ? '... Ver menos' : '... Ver más';
            }
        }
    </script>

</body>