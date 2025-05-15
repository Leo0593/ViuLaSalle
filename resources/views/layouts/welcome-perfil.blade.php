@if (Auth::check())
    <div style="width: 100%; display: flex; gap: 10px; flex-direction: column; margin-bottom:20px;">
                        <div class="notif-container">
                            <a class="botones-new-1  notif-btn" style="color:white !important;"
                                onclick="toggleNotificaciones()">
                                <i class="fa-solid fa-bell" style="margin-right: 5px;"></i>
                                Notificaciones
                            </a>

                            <div class="notif-window" id="ventanaNotificaciones">
                                <ul>
                                    @if ($notificaciones->isEmpty())
                                        <li>
                                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                                            <div class="notif-content">
                                                <p class="notif-title">Sin notificaciones</p>
                                                <p class="notif-message">No tienes notificaciones nuevas.</p>
                                            </div>
                                        </li>
                                    @endif
                                    @foreach ($notificaciones as $notificacion)
                                        <li>
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            <div class="notif-content">
                                                <p class="notif-title">{{ $notificacion->titulo }}</p>
                                                <p class="notif-message">{{ $notificacion->mensaje }}</p>
                                                <p class="notif-time"><i class="fa-regular fa-clock"></i>
                                                    {{ $notificacion->created_at->diffForHumans() }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Botón Editar Perfil -->
                        <a class="botones-new-1" href="{{ route('profile.edit') }}"
                            style="background-color: #0d6efd; color: white; padding: 8px 16px; border: none; border-radius: 10px; text-decoration: none; display: flex; align-items: center;">
                            <i class="fa fa-user-edit" style="margin-right: 5px;"></i> Editar Perfil
                        </a>

                        <a class="botones-new-1" href="{{ route('colecciones.misgrupos') }}"
                            style="background-color: #ffb706; color: white; padding: 8px 16px; border: none; border-radius: 10px; text-decoration: none; display: flex; align-items: center;">
                            <i class="fa fa-users" style="margin-right: 5px;">
                            </i> Mis Grupos
                        </a>

                        <!-- Botón Cerrar Sesión -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="botones-new-1" type="submit"
                                style="background-color: #dc3545; color: white; padding: 8px 16px; border: none; border-radius: 10px; cursor: pointer; display: flex; align-items: center; width: 100%;">
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
                            <h3>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</h3>
                        </div>
                        <p><strong>Correo: </strong>
                            <!-- {{ Auth::check() ? Auth::user()->email : 'No disponible' }} --></p>
                        <p><strong>Teléfono: </strong> {{ Auth::check() ? Auth::user()->phone : 'No disponible' }}</p>
                        <p><strong>Fecha de nacimiento: </strong>
                            {{ Auth::check() ? Auth::user()->birthdate : 'No disponible' }}</p>
                        <p><strong>Descripción: </strong>
                            {{ Auth::check() ? Auth::user()->description : 'No disponible' }}</p>
                        <p><strong>Ubicación: </strong> {{ Auth::check() ? Auth::user()->location : 'No disponible' }}
                        </p>
                    </div>

</div>