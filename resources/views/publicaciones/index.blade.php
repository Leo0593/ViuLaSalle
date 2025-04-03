<!-- resources/views/publicaciones/index.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Publicaciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.like-btn').click(function () {
            let button = $(this);
            let publicacionId = button.data('id');

            $.ajax({
                url: '/publicaciones/' + publicacionId + '/like',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    button.find('.like-count').text(response.likes);
                    button.css('color', response.liked ? 'red' : 'black');
                }
            });
        });
    });
</script>

<body>
    <div class="container mt-5">
        <h1>Listado de Publicaciones</h1>
        <a href="{{ route('publicaciones.create') }}" class="btn btn-primary mb-3">Crear Publicación</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Fecha de Publicación</th>
                    <th>Usuario</th>
                    <th>Evento</th>
                    <th>Status</th>
                    <th>Fotos</th> <!-- Columna nueva para mostrar las fotos -->
                    <th>Likes</th> <!-- Nueva columna para mostrar los likes -->
                    <th>Reportar</th> <!-- Nueva columna para reportar la publicación -->
                    <th>Activar Comentarios</th>
                    <th>Comentarios</th>
                    <th>Acciones</th> <!-- Para los botones de editar y activar/desactivar -->
                    <th>Videos</th> <!-- Columna de Videos -->
                    <th>Categorías</th>

                </tr>
            </thead>
            <tbody>
                @foreach($publicaciones as $publicacion)
                                <tr>
                                    <td>{{ $publicacion->id }}</td>
                                    <td>{{ $publicacion->descripcion }}</td>
                                    <td>{{ $publicacion->fecha_publicacion->format('d/m/Y') }}</td>
                                    <td>{{ $publicacion->usuario->name }}</td> <!-- Suponiendo que el usuario tiene un campo 'name' -->
                                    <td>{{ $publicacion->evento->nombre }}</td>
                                    <!-- Suponiendo que el evento tiene un campo 'nombre' -->
                                    <td>{{ $publicacion->status }}</td>

                                    <!-- Columna de fotos -->
                                    <td>
                                        @if($publicacion->fotos->count() > 0)
                                            <div class="d-flex flex-wrap">
                                                @foreach($publicacion->fotos as $foto)
                                                    <div class="mr-2">
                                                        <!-- Mostrar las fotos con la ruta correcta usando Storage::url() -->
                                                        <img src="{{ Storage::url('public/publicaciones/' . $foto->ruta_foto) }}" alt="Foto"
                                                            width="auto" height="100">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>No hay fotos</p>
                                        @endif
                                    </td>


                                    <!-- Mostrar la cantidad de likes -->
                                    <td>
                                        <button class="like-btn" data-id="{{ $publicacion->id }}"
                                            style="color: {{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'red' : 'black' }};">
                                            ❤️ <span class="like-count">{{ $publicacion->likes }}</span>
                                        </button>
                                    </td>

                                    <td>
                                        <!-- Verificar si el usuario ya reportó la publicación -->
                                        @php
                                            $yaReportado = \App\Models\Reporte::where('user_id', auth()->id())
                                                ->where('publicacion_id', $publicacion->id)
                                                ->exists();
                                        @endphp

                                        @if (!$yaReportado)
                                            <form action="{{ route('publicaciones.reportar', $publicacion->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">Reportar</button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>Reportado</button>
                                        @endif
                                    </td>

                                    <!-- activador de boton de comentarios -->

                                    <td>{{ $publicacion->activar_comentarios }}</td>

                                    <!-- boton de comentarios -->

                                    <td>
                                        @if($publicacion->activar_comentarios == 1)
                                            <a href="{{ route('comentarios.ver', $publicacion->id) }}" class="btn btn-primary">
                                                Ver Comentarios
                                            </a>
                                        @endif
                                    </td>

                                    <!-- Columna de botones -->

                                    <td>
                                        @if($user->role == 'ADMIN' || $publicacion->id_user === auth()->id())

                                            <a href="{{ route('publicaciones.edit', $publicacion->id) }}"
                                                class="btn btn-warning btn-sm">Editar</a>

                                            <!-- Condicional para mostrar el botón de eliminar o activar -->
                                            @if ($publicacion->status == 1)
                                                <!-- Botón de eliminar con un formulario -->
                                                <form action="{{ route('publicaciones.destroy', $publicacion->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Estás seguro de que deseas desactivar esta publicación?')">Eliminar</button>
                                                </form>
                                            @else
                                                <!-- Botón de activar con un formulario -->
                                                <form action="{{ route('publicaciones.activate', $publicacion->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        onclick="return confirm('¿Estás seguro de que deseas activar esta publicación?')">Activar</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>

                                    <!-- Columna de Videos -->
                                    <td>
                                        @if($publicacion->videos->count() > 0)
                                            <div class="d-flex flex-wrap">
                                                @foreach($publicacion->videos as $video)
                                                    <div class="mr-2">
                                                        <video width="200" height="150" controls>
                                                            <source src="{{ Storage::url('publicvideos/' . $video->ruta_video) }}"
                                                                type="video/mp4">
                                                            Tu navegador no soporta el video.
                                                        </video>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>No hay videos</p>
                                        @endif
                                    </td>

                                    <td>
                                        @if($publicacion->categorias->count() > 0)
                                            <ul>
                                                @foreach($publicacion->categorias as $categoria)
                                                    <li>{{ $categoria->nombre }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No hay categorías</p>
                                        @endif
                                    </td>

                                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>