@if (Auth::check())
    <div style="width: 100%; display: flex; gap: 20px; flex-direction: column; margin-bottom:30px;">
        <div class="notif-container">
            <a class="botones-new-1 perfil-botones  notif-btn" style="color:white !important; pointer-events: auto;"
                    onclick="toggleNotificaciones()">
                <i class="fa-solid fa-bell" style="margin-right: 5px;"></i>
                Notificaciones
            </a>

            <div class="notif-window" id="ventanaNotificaciones">
                <ul>
                    @forelse ($notificaciones as $notificacion)
                        <li>
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <div class="notif-content">
                                <p class="notif-title">{{ $notificacion->titulo }}</p>
                                <p class="notif-message">{{ $notificacion->mensaje }}</p>
                                <p class="notif-time"><i class="fa-regular fa-clock"></i>
                                {{ $notificacion->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @empty
                        <li>
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <div class="notif-content">
                                <p class="notif-title">Sin notificaciones</p>
                                <p class="notif-message">No tienes notificaciones nuevas.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
                <!-- Paginación -->    
                @if ($notificaciones->hasPages())
                    <div class="d-flex justify-content-center mt-3 mt-md-4">
                        {{ $notificaciones->links() }}
                    </div>
                @endif
            </div> 
        </div>

        <!-- Botón Editar Perfil -->
        <a class="botones-new-1 perfil-botones" href="{{ route('profile.edit') }}"
                style="background-color: #0d6efd;">
            <i class="fa fa-user-edit" style="margin-right: 5px;"></i> Editar Perfil
        </a>

        <a class="botones-new-1 perfil-botones" href="{{ route('colecciones.misgrupos') }}"
                style="background-color: #ffb706;">
            <i class="fa fa-users" style="margin-right: 5px;"></i> 
            Mis Grupos
        </a>

        <!-- Botón Cerrar Sesión -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="botones-new-1 perfil-botones" type="submit"
                    style="background-color: #dc3545;">
                <i class="fa fa-sign-out-alt" style="margin-right: 5px;"></i> Cerrar Sesión
            </button>
        </form>
    </div>
@endif

<div class="perfil-box">
    <div class="perfil-header">
        <img src="../../img/Fondo.png" alt="Fondo de perfil">
    </div>

    <div class="perfil-foto">
        @if(Auth::check() && Auth::user()->avatar)
            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar usuario"
                    onerror="this.onerror=null;this.src='{{ asset('img/user-icon.png') }}';">
        @else
            <img src="{{ asset('img/user-icon.png') }}" alt="Avatar por defecto">
        @endif
    </div>

    <!-- Overlay borroso y botón -->
    @if(!Auth::check())
        <div class="perfil-overlay">
            <a href="{{ route('login') }}" class="btn-login">
                <strong>Iniciar Sesión</strong>
            </a>

            <a href="{{ route('register') }}" class="btn-register">
                <strong>Registrarse</strong>
            </a>
        </div>
    @endif

    <div class="perfil-info">
        <div class="center-text" style="margin-bottom: 10px;">
            <h3> 
                {{ Auth::check() ? Auth::user()->name : 'Invitado' }}
                @if (Auth::check() && Auth::user()->status == '1')
                    <i class="fa fa-check-circle" style="color: green;" aria-hidden="true"></i>
                @elseif (Auth::check() && Auth::user()->status == '0')
                    <i class="fa fa-times-circle" style="color: red;" aria-hidden="true"></i>
                @else
                @endif
            </h3>
        </div>
        <p><strong>Rol: </strong>
            @if(Auth::check() && Auth()->user()->role == 'USER')
                Alumno <i class="fa fa-user-graduate" aria-hidden="true"></i>
            @elseif(Auth::check() && Auth()->user()->role == 'ADMIN')
                Administrador <i class="fa fa-user-shield" aria-hidden="true"></i>
            @elseif(Auth::check() && Auth()->user()->role == 'PROFESOR')
                Profesor <i class="fa fa-chalkboard-teacher" aria-hidden="true"></i>
            @endif
        </p>
        <p><strong>Correo: </strong>
            {{ Auth::check() ? Auth::user()->email : 'No disponible' }}</p>
        @if (Auth::check() && !empty(Auth::user()->phone))
        <p><strong>Teléfono: </strong> 
            {{ Auth::check() ? Auth::user()->phone : 'No disponible' }}</p>
        @endif
        @if (Auth::check() && !empty(Auth::user()->descripcion)) 
        <p><strong>Descripción: </strong>
            {{ Auth::check() ? Auth::user()->description : 'No disponible' }}</p>
        @endif
    </div>
</div>