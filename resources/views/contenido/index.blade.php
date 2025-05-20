@include('layouts.head')

{{-- Estilos CSS --}}

<div>
    <a href="{{ route('contenido.create') }}" style="padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px;">Crear Nuevo Contenido</a>
</div>

<h1>Listado de Contenidos</h1>

@if(session('success'))
    <div style="color:green;">{{ session('success') }}</div>
@endif

{{-- Tabla con contenidos --}}
<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Vista</th>
            <th>Vista Tipo</th>
            <th>Tipo</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Video</th>
            <th>Opción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contenidos as $contenido)
        <tr>
            <td>{{ $contenido->id }}</td>
            <td>{{ $contenido->id_vista }}</td>
            <td>{{ $contenido->vista_tipo }}</td>
            <td>{{ $contenido->tipo }}</td>
            <td>{{ $contenido->titulo }}</td>
            <td>{{ $contenido->descripcion }}</td>
            <td>{{ $contenido->imagen }}</td>
            <td>{{ $contenido->video }}</td>
            <td>{{ $contenido->opcion }}</td>
            <td>
                <a href="{{ route('contenido.edit', $contenido->id) }}" style="padding: 5px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 5px;">Editar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@foreach ($contenidos as $contenido)
    <div class="contenido-box" style="margin-top: 20px;">
        @if($contenido->opcion == 0)
            <div class="contenido-box-opc-0">
                <td>{{ $contenido->titulo }}</td>
                <td>{{ $contenido->descripcion }}</td>
            </div>
        @elseif($contenido->opcion == 1)
            <div class="contenido-box-opc-1">
                <div class="contenido-box-opc-1-text">
                    <td>{{ $contenido->titulo }}</td>
                    <td>{{ $contenido->descripcion }}</td>
                </div>
                <div class="contenido-box-opc-1-img">
                    <img src="{{ asset('storage/' . $contenido->imagen) }}" alt="Imagen actual">
                </div>
            </div>
        @elseif($contenido->opcion == 2)
            <div class="contenido-box-opc-1">
                <div class="contenido-box-opc-1-img">
                    <img src="{{ asset('storage/' . $contenido->imagen) }}" alt="Imagen actual">
                </div>
                <div class="contenido-box-opc-1-text">
                    <td>{{ $contenido->titulo }}</td>
                    <td>{{ $contenido->descripcion }}</td>
                </div>
            </div>
        @endif

    </div>
@endforeach
