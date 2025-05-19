@php 
    use Illuminate\Support\Collection;

    $niveles = $niveles ?? [];
    $notificaciones = collect($notificaciones ?? []);
@endphp

<header>
    <div class="header-content">
        <button class="btn-header back scale-btn" onclick="history.back()">
            <i class="fa fa-reply-all" aria-hidden="true"></i>
        </button>
        <div class="logo-container">
            <a  href="/">
                <img src="../../img/ViuSalle.png" alt="Viu LaSalle">
            </a>
        </div>  
        <button class="btn-header menu scale-btn toggle-btn">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>

<aside id="sidebar">
    @include('layouts.welcome-perfil', ['notificaciones' => $notificaciones])

    <br><br>
    @include('layouts.redirecciones', ['niveles' => $niveles])
</aside>