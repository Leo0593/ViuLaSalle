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
                    <div class="misgrupos-izq-grupos-grupo grupo-item" data-id="{{ $coleccion->id }}">
                        <div class="misgrupos-izq-grupos-grupo-foto">
                            <img src="{{ asset('img/user-icon.png') }}" alt="Grupo {{ $coleccion->nombre }}">
                        </div>
                        <div class="misgrupos-izq-grupos-grupo-texto">
                            <h1>{{ $coleccion->nombre }}</h1>
                            <p>{{ $coleccion->descripcion ?? 'Sin descripción' }}</p>
                        </div>
                    </div>

                @empty
                    <p class="text-muted ms-2">No tienes grupos disponibles.</p>
                @endforelse
            </div>
        </div>

        <div class="misgrupos-der" id="grupoDetalle">
            <div class="misgrupos-der-carga">
                <h1>Selecciona un grupo para ver el chat</h1>
                <p>¡Comienza a chatear con tus amigos!</p>
                <i class="fa-solid fa-comments"></i>
            </div>




            <!--
            <div class="misgrupos-der-header">
                <img src="../../img/user-icon.png" alt="Grupo">
                <h1>Nombre del Grupo</h1>
            </div>

            <div class="misgrupos-der-chat">
                
                {{-- Mensaje Emisor --}}
                <div class="mis-grupos-mensajes-container emisor">
                    <div class="mis-grupos-mensaje-emisor">
                        @for ($i = 0; $i < 15; $i++)
                            <div class="mensaje-burbuja">
                                <p>Todo bien, ¿y tú?</p>
                                <span class="mensaje-hora mhe">10:32</span>
                            </div>
                        @endfor
                    </div>
                    
                    <div class="mensaje-perfil">
                        <img src="../../img/user-icon.png" alt="Perfil">
                    </div>
                </div>

                {{-- Mensaje Receptor --}}
                <div class="mis-grupos-mensajes-container receptor">
                    <div class="mensaje-perfil">
                        <img src="../../img/user-icon.png" alt="Perfil">
                    </div>
                
                    <div class="mis-grupos-mensaje-receptor">
                        @for ($i = 0; $i < 15; $i++)
                            <div class="mensaje-burbuja">
                                <p>Hola, ¿cómo estás?</p>
                                <span class="mensaje-hora">10:30</span>
                            </div>
                        @endfor
                    </div>
                </div> 
            </div>

            <div style="padding: 10px;">
                <div class="misgrupos-der-footer">
                    <button class="icon-btn">
                        <i class="fa-regular fa-face-smile"></i>
                    </button>
                    <input
                        type="text"
                        placeholder="Enviar mensaje..."
                        class="chat-input"
                    />
                    <div class="chat-icons-right">
                        <button class="icon-btn" title="Audio">
                            <i class="fa-solid fa-microphone"></i>
                        </button>
                        <button class="icon-btn" title="Imagen">
                            <i class="fa-regular fa-image"></i>
                        </button>
                        <button class="icon-btn" title="Reaccionar">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>
                    <button class="send-btn" title="Enviar">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
            -->
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