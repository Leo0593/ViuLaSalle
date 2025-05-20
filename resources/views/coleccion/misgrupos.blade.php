@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="misgrupos-body">
        <div class="misgrupos-izq">
            <div class="misgrupos-izq-header">
                <div class="misgrupos-izq-header-escribir">
                    <div>
                        <h1>Mis Grupos</h1>
                    </div>
                    <div>
                        <button class="btn-creargrupo" id="crearGrupoBtn" title="Crear nuevo grupo">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>
                </div>

                <div class="misgrupos-izq-header-buscar">
                    <input type="text" placeholder="Buscar..." class="misgrupos-izq-header-buscar-input" />
                    <button class="icon-btn" title="Buscar">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>

            <div class="misgrupos-izq-grupos">
                @forelse ($colecciones as $coleccion)
                    <div class="misgrupos-izq-grupos-desktop">
                        <div class="misgrupos-izq-grupos-grupo grupo-item" data-id="{{ $coleccion->id }}">
                            <div class="misgrupos-izq-grupos-grupo-foto">
                                <img src="{{ asset('img/user-icon.png') }}" alt="Grupo {{ $coleccion->nombre }}">
                            </div>
                            <div class="misgrupos-izq-grupos-grupo-texto">
                                <h1>{{ $coleccion->nombre }}</h1>
                                <p>{{ $coleccion->descripcion ?? 'Sin descripción' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="misgrupos-izq-grupos-mobile">
                        <a class="misgrupos-izq-grupos-grupo grupo-item" href="{{ route('colecciones.show', $coleccion->id) }}" data-id="{{ $coleccion->id }}">
                            <div class="misgrupos-izq-grupos-grupo-foto">
                                <img src="{{ asset('img/user-icon.png') }}" alt="Grupo {{ $coleccion->nombre }}">
                            </div>
                            <div class="misgrupos-izq-grupos-grupo-texto">
                                <h1>{{ $coleccion->nombre }}</h1>
                                <p>{{ $coleccion->descripcion ?? 'Sin descripción' }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-muted ms-2 text-center">No tienes grupos disponibles.</p>
                @endforelse
            </div>
        </div>

        <div class="misgrupos-der" id="grupoDetalle">
            <div class="misgrupos-der-carga">
                <h1>Selecciona un grupo para ver el chat</h1>
                <p>¡Comienza a chatear con tus amigos!</p>
                <i class="fa-solid fa-comments"></i>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.grupo-item', function () {
            const grupoId = $(this).data('id');

            $.ajax({
                url: `/colecciones/${grupoId}`, // Usa la ruta show con el ID
                method: 'GET',
                success: function (response) {
                    $('#grupoDetalle').html(response); // Carga la vista completa en el div
                },
                error: function () {
                    $('#grupoDetalle').html('<p class="text-danger">Error al cargar el grupo.</p>');
                }
            });
        });
    </script>

</body>