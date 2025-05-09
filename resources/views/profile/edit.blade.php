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
        <div class="perfil-posts">
            @if(isset($publicaciones) && $publicaciones->isNotEmpty())
                @foreach ($publicaciones as $publicacion)
                    @if($publicacion->id_user == Auth::user()->id)
                        @php
                            $hayPublicaciones = true;
                        @endphp
                        <div class="perfil-posts-post">
                            @include('layouts.publicacion', ['publicacion' => $publicacion])     
                        </div>
                    @endif
                @endforeach
            @endif

            @if (!$hayPublicaciones)
                <div class="alert alert-info text-center">
                    <strong>No hay eventos disponibles.</strong>
                </div>
            @endif
        </div>
    </div>
</body>
