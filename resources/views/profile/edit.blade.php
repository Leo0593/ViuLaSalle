@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="perfil-body">

        <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
            <!-- Banner -->
            <div class="perfil-banner-container">
                <div class="perfil-banner">
                    <img src="../../img/Fondo.png" alt="Banner de perfil">
                </div>

                <!-- Imagen de perfil y nombre -->
                <div class="foto-perfil">
                    <div class="perfil-img">
                        @if(Auth::check() && Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar usuario"
                                onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
                        @else
                            <img src="{{ asset('img/user-icon.png') }}" alt="Avatar por defecto">
                        @endif
                    </div>
                </div>
            </div>

            <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
                <div class="info-perfil">
                    <h1 class="perfil-nombre">{{ Auth::check() ? Auth::user()->name : '' }}</h1>
                    <p class="perfil-descripcion">{{ Auth::check() ? Auth::user()->descripcion : '' }}</p>
                    <p class="perfil-email">{{ Auth::check() ? Auth::user()->email : '' }}</p>
                    <p class="perfil-telefono">{{ Auth::check() ? Auth::user()->telefono : '' }}</p>
                    <p class="perfil-fecha-nacimiento">{{ Auth::check() ? Auth::user()->fecha_nacimiento : '' }}</p>
                    <p class="perfil-rol">{{ Auth::check() ? Auth::user()->rol : '' }}</p>
                </div>
            </div>
        </div>

        @php
            $hayPublicaciones = false;
        @endphp
        <div style="display: flex; flex-direction: column; width: 100%; align-items: center; margin-top: 80px; margin-bottom: 50px;">
            <div class="clase-posts-separador">
                <i class="fa fa-th" aria-hidden="true"></i>
            </div>
            <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
                <div class="clase-posts">
                    @if (!empty($publicaciones) && $publicaciones->isNotEmpty() && $publicaciones->filter(fn($p) => $p->id_user == Auth::id())->isNotEmpty())
                        @include('layouts.publicacion-grid', ['publicaciones' => $publicaciones])
                    @else
                        <div style="grid-column: 1 / -1; display: flex; justify-content: center; align-items: center;">
                            <p class="text-muted ms-2 mt-3 text-center">No has publicado nada aún.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

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

    <script src="{{ asset('/js/publicacion-modal.js') }}"></script>

</body>