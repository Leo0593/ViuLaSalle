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
                        @if(auth()->user()->role === 'ADMIN' || auth()->user()->role === 'PROFESOR')

                            <button class="btn btn-primary" id="crearGrupoBtn" title="Crear nuevo grupo">
                                <i class="fa-solid fa-pen-to-square"></i> Crear Grupo
                            </button>
                        @endif

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
                        <div class="misgrupos-izq-grupos-grupo grupo-item position-relative" data-id="{{ $coleccion->id }}">

                            {{-- Mostrar botones solo si el usuario es admin o el creador --}}
                            @if(auth()->user()->role === 'ADMIN' || auth()->user()->id === $coleccion->creador_id)
                                <div class="grupo-acciones position-absolute top-0 end-0 m-2 d-flex gap-2">
                                    <!-- Botón de Editar -->
                                    <a href="{{ route('colecciones.edit', $coleccion->id) }}" class="btn btn-sm btn-warning"
                                        title="Editar">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>

                                    <!-- Activar/Desactivar -->
                                    @if ($coleccion->status)
                                        <form method="POST" action="{{ route('colecciones.destroy', $coleccion->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Desactivar"
                                                onclick="return confirm('¿Desactivar esta colección?')">
                                                <i class="fa-solid fa-ban"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('colecciones.activate', $coleccion->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-success" title="Activar"
                                                onclick="return confirm('¿Activar esta colección?')">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif

                            <!-- Contenido del grupo -->
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
                        <a class="misgrupos-izq-grupos-grupo grupo-item"
                            href="{{ route('colecciones.show', $coleccion->id) }}" data-id="{{ $coleccion->id }}">
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

    <!-- Modal Crear Grupo -->
    <div class="modal fade" id="crearGrupoModal" tabindex="-1" aria-labelledby="crearGrupoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearGrupoModalLabel">Crear Nueva Colección</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">

                    <!-- Formulario dentro del modal -->
                    <form action="{{ route('colecciones.store') }}" method="POST" id="formCrearGrupo">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Colección</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                        </div>

                        <div class="mb-3" id="usuarios_select_modal">
                            <input type="text" id="buscar_usuario_modal" class="form-control mb-2"
                                placeholder="Buscar usuario..." onkeyup="filtrarUsuariosModal()">
                            <div id="usuarios_checklist_modal" class="border rounded p-2"
                                style="max-height: 150px; overflow-y: auto;">
                                @foreach ($users as $user)
                                    <div class="form-check usuario-item-modal"
                                        data-nombre="{{ strtolower($user->name) }} {{ strtolower($user->email) }}">
                                        <input class="form-check-input usuario-checkbox-modal" type="checkbox"
                                            name="usuarios[]" value="{{ $user->id }}" id="user_modal_{{ $user->id }}">
                                        <label class="form-check-label" for="user_modal_{{ $user->id }}">
                                            {{ $user->name }} ({{ $user->email }})
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Crear Grupo</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Activar modal al hacer clic en el botón
        document.getElementById('crearGrupoBtn').addEventListener('click', function () {
            const modal = new bootstrap.Modal(document.getElementById('crearGrupoModal'));
            modal.show();
        });

        // Filtro de usuarios dentro del modal
        function filtrarUsuariosModal() {
            const input = document.getElementById('buscar_usuario_modal').value.toLowerCase();
            const items = document.querySelectorAll('.usuario-item-modal');

            items.forEach(item => {
                const nombre = item.getAttribute('data-nombre');
                item.style.display = nombre.includes(input) ? 'block' : 'none';
            });
        }

        // Reordenar usuarios seleccionados al principio
        function reordenarUsuariosModal() {
            const contenedor = document.getElementById('usuarios_checklist_modal');
            const items = Array.from(contenedor.querySelectorAll('.usuario-item-modal'));

            const seleccionados = items.filter(i => i.querySelector('input').checked);
            const noSeleccionados = items.filter(i => !i.querySelector('input').checked);

            contenedor.innerHTML = '';
            seleccionados.forEach(i => contenedor.appendChild(i));
            noSeleccionados.forEach(i => contenedor.appendChild(i));
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Escuchar cambios en los checkboxes dentro del modal
            document.querySelectorAll('.usuario-checkbox-modal').forEach(cb => {
                cb.addEventListener('change', reordenarUsuariosModal);
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.grupo-item', function () {
            const grupoId = $(this).data('id');

            $.ajax({
                url: `/colecciones/${grupoId}`,
                method: 'GET',
                success: function (response) {
                    $('#grupoDetalle').html(response);

                    // Inicializar funcionalidades dinámicas
                    inicializarCarruseles();       // Carrusel
                    inicializarModalImagen();      // Modal de imagen
                },
                error: function () {
                    $('#grupoDetalle').html('<p class="text-danger">Error al cargar el grupo.</p>');
                }
            });
        });
    </script>


</body>