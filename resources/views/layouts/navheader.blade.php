<header>
    <button class="btn-menu scale-btn toggle-btn" id="bt1">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="logo-container">
        <a href="{{ route('welcome') }}">
            <img src="../../img/ViuSalle.png" alt="Viu LaSalle">
        </a>
    </div>
</header>

<aside id="sidebar">
    <ul class="sidebar-nav">

        <div class="sidebar-separator">Home</div>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('welcome') }}">
                <i class="fa-solid fa-house"></i>
                <span>Inicio</span>
            </a>
        </li>

        <div class="sidebar-separator">Intefaces</div>
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('info.index') }}">
                <i class="fa-solid fa-info-circle"></i>
                <span>Evento</span>
            </a>
        </li>
    </ul>
</aside>