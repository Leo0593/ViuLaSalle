<div class="opciones-bar-separator" style="margin-top: 0;">Home</div>

    {{-- Inicio --}}  
<li class="opciones-bar-item">
    <a class="opciones-bar-link" href="/">
        <i class="fa-solid fa-house"></i>
        <span>Inicio</span>
    </a>
</li>

    {{-- Perfil --}}
<li class="opciones-bar-item">
    <a class="opciones-bar-link" href="{{ route('profile.edit') }}">
        <i class="fa-solid fa-user"></i>
        <span>Perfil</span>
    </a>
</li>

    {{-- Eventos --}}
<li class="opciones-bar-item">
    <a class="opciones-bar-link" href="{{ route('eventos.todos') }}">
        <i class="fa-solid fa-calendar"></i>
        <span>Eventos</span>
    </a>
</li>

    {{-- Admin --}}
@auth
    @if (auth()->user()->role == 'ADMIN')
        <li class="opciones-bar-item">
            <a class="opciones-bar-link" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-tachometer-alt"></i> <!-- Icono de dashboard -->
                <span>Dashboard</span>
            </a>
        </li>
    @endif
@endauth

<li class="opciones-bar-item">
    <a class="opciones-bar-link" href="{{ route('niveles.show') }}">
        <i class="fa-solid fa-calendar-plus"></i>
        <span>Show</span>
    </a>
</li>

<div class="opciones-bar-separator">Niveles Educaticos</div>

@foreach ($niveles as $nivel)
    @if (is_null($nivel->id_nivel))
        @include('layouts.nivel-item', ['nivel' => $nivel, 'niveles' => $niveles])
    @endif
@endforeach