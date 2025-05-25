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
        </div>

        <div class="perfil-body-cont">
            <div style="width: 100%; display: flex; flex-direction: column; align-items: center; gap: 20px;">
                <div class="info-perfil">
                    <h1 class="perfil-nombre">{{ Auth::check() ? Auth::user()->name : '' }}
                        @if (Auth::user()->status == 1)
                            <i class="fa fa-check-circle" style="color: green;" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-times-circle" style="color: red;" aria-hidden="true"></i>
                        @endif
                    </h1>
                    @if (Auth::check() && !empty(Auth::user()->role)) 
                        <div class="perfil-info-container">
                            <h4 class="perfil-rol">
                                <i class="fa fa-user-tag" aria-hidden="true"></i>
                                Rol:
                            </h4>
                            <p class="perfil-rol">
                                @if(Auth()->user()->role  == 'USER')
                                    Alumno <i class="fa fa-user-graduate" aria-hidden="true"></i>
                                @elseif(Auth()->user()->role  == 'ADMIN')
                                    Administrador <i class="fa fa-user-shield" aria-hidden="true"></i>
                                @elseif(Auth()->user()->role  == 'PROFESOR')
                                    Profesor <i class="fa fa-chalkboard-teacher" aria-hidden="true"></i>
                                @endif
                            </p>
                        </div>
                    @endif
                    @if (Auth::check() && !empty(Auth::user()->email))
                        <div class="perfil-info-container">
                            <h4 class="perfil-email">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                Correo:
                            </h4>
                            <p class="perfil-email">{{ Auth::user()->email }}</p>
                        </div>
                    @endif
                    @if (Auth::check() && !empty(Auth::user()->phone))
                        <div class="perfil-info-container">
                            <h4 class="perfil-telefono">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                Teléfono:
                            </h4>
                            <p class="perfil-telefono">{{ Auth::user()->phone }}</p>
                        </div>
                    @endif
                    @if (Auth::check() && !empty(Auth::user()->descripcion))
                        <div class="perfil-info-container">
                            <h4 class="perfil-descripcion">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                Descripción:
                            </h4>
                            <p class="perfil-descripcion">{{ Auth::user()->descripcion }}</p>
                        </div>
                    @endif
                </div>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-editar-perfil">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                    Editar Perfil
                </a>
            </div>
        </div>

        @php
            $hayPublicaciones = false;
        @endphp
        <div style="display: flex; flex-direction: column; width: 100%; align-items: center; margin-top: 60px; margin-bottom: 60px;">
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