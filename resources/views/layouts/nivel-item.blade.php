<li class="opciones-bar-item {{ $nivel->id_nivel ? 'subnivel' : '' }}">
    <a href="#" class="opciones-bar-link toggle-nivel" data-nivel="{{ $nivel->id }}">
        <i class="fa fa-arrow-circle-right toggle-icon" aria-hidden="true"></i>
        <span>{{ $nivel->nombre }}</span>
    </a>

    <ul class="nivel-hijos" id="nivel-{{ $nivel->id }}" style="padding-left: 20px; margin-bottom: 0px; display: none;">
        {{-- Mostrar cursos del nivel --}}
        @foreach ($nivel->cursos as $curso)
            <li class="opciones-bar-item subnivel" style="padding-left: 0px; margin-bottom: 0px;">
                <a class="opciones-bar-link" href="{{ route('cursos.show', $curso->id) }}">
                    <span>{{ $curso->nombre }}</span>
                </a>
            </li>
        @endforeach

        {{-- Mostrar subniveles recursivamente --}}
        @foreach ($niveles as $subnivel)
            @if ($subnivel->id_nivel === $nivel->id)
                @include('layouts.nivel-item', ['nivel' => $subnivel, 'niveles' => $niveles])
            @endif
        @endforeach
    </ul>
</li>