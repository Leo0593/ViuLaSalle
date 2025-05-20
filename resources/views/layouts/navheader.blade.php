@php 
    use Illuminate\Support\Collection;

    $niveles = $niveles ?? [];
    $notificaciones = collect($notificaciones ?? []);
@endphp

<header>
    <div class="header-content">
        <div class="left-slot">
            <button class="btn-header back scale-btn" onclick="history.back()">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </button>
        </div>

        <div class="logo-container">
            <a  href="/">
                <img src="../../img/ViuSalle.png" alt="Viu LaSalle">
            </a>
        </div>  
        
        <div class="right-slot">
            @if(Route::currentRouteName() === 'welcome')
                <button class="btn-header menu scale-btn toggle-btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
            @endif
        </div>
    </div>
</header>

@if(Route::currentRouteName() === 'welcome')
    <aside id="sidebar">
        @include('layouts.welcome-perfil', ['notificaciones' => $notificaciones])

        <br><br>
        @include('layouts.redirecciones', ['niveles' => $niveles])
    </aside>
@endif
