@include('layouts.head')

<body>

    @include('layouts.navheader')

    <div class="eventos-main">

        @foreach ($eventos as $evento)
            <a class="evento-container" style=" background-image: linear-gradient(to top, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0)), url('{{ Storage::url($evento->foto) }}');"
                href="{{ route('eventos.show', $evento->id) }}"
                >
                <div class="evento-texto">
                    <h2>{{ $evento->nombre }}</h2>
                    <p>{{ $evento->descripcion }}</p>
                </div>
            </a>
        @endforeach

        @for ($i = 0; $i < 4; $i++)
            <div class="evento-container">
                a
            </div>
        @endfor
    </div>

    @include('layouts.footer')
</body>