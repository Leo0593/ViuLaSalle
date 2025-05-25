@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container py-4 margin-top-header">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 text-dark fw-bold">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    Editando evento: {{ $evento->nombre }}
                </h5>
            </div>

            <div class="card-body p-4">
                {{-- Mostrar errores de validación --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nombre del evento --}}
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Evento</label>
                        <input type="text" class="form-control shadow-sm" id="nombre" name="nombre"
                               value="{{ old('nombre', $evento->nombre) }}" required>
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                        <textarea class="form-control shadow-sm" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion', $evento->descripcion) }}</textarea>
                    </div>

                    {{-- Imagen actual --}}
                    @if ($evento->foto)
                        <div class="mb-3">
                            <label class="form-label">Imagen actual:</label>
                            <div class="d-flex align-items-center gap-2 p-2 border rounded bg-light">
                                <img src="{{ asset('storage/' . $evento->foto) }}" alt="Imagen del evento" class="img-thumbnail rounded" style="max-width: 200px;">
                            </div>
                        </div>
                    @endif

                    {{-- Nueva imagen --}}
                    <div class="mb-4">
                        <label for="foto" class="form-label fw-semibold">Nueva imagen (opcional)</label>
                        <input type="file" class="form-control shadow-sm" id="foto" name="foto" accept="image/*">
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-success shadow-sm">
                            <i class="fas fa-save me-1"></i> Guardar cambios
                        </button>
                        <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary shadow-sm">
                            Cancelar
                        </a>
                    </div>
                </form>

                <div class="mb-4 mt-4">
                    <button type="button" class="agregar-contenido" data-bs-toggle="modal" data-bs-target="#crearContenedorModal">
                        <div class="contenido-inner">
                            <i class="fas fa-plus-circle"></i>
                            <div class="texto">Añadir contenido</div>
                        </div>
                    </button>
                </div>

                <div class="mt-4">
                    <h5>Contenidos del curso</h5>

                    @if($contenidos->count() > 0)
                        <div class="list-group">
                            @foreach($contenidos as $contenedor)
                                <div class="list-group-item d-flex justify-content-between align-items-center" style="gap: 10px;">
                                    <div style="display: flex; gap: 5px; flex-direction: column">
                                        @if ($contenedor->tipo == 'columna')
                                            <div style="color: var(--azul);">
                                                @if ($contenedor->opcion == 0)
                                                    <strong>Columna</strong> -
                                                    <strong>Opcion 1</strong> -
                                                    <i class="fa fa-list" aria-hidden="true"></i>
                                                @elseif ($contenedor->opcion == 1)
                                                    <strong>Columna</strong> -
                                                    <strong>Opcion 2</strong> -
                                                    <i class="fa fa-table" aria-hidden="true"></i>
                                                @endif
                                            </div>
                                        @elseif ($contenedor->tipo == 'contenedor')
                                            <div style="color: var(--azul);">
                                                @if ($contenedor->opcion == 0)
                                                    <strong>Opcion 1</strong> -
                                                    <strong>Contenedor</strong> -
                                                    <i class="fa fa-align-justify" aria-hidden="true"></i>
                                                @elseif ($contenedor->opcion == 1)
                                                    <strong>Opcion 2</strong> -
                                                    <strong>Contenedor</strong> -
                                                    <i class="fa fa-align-left" aria-hidden="true"></i>
                                                    <i class="fa fa-image" aria-hidden="true"></i>    
                                                @elseif ($contenedor->opcion == 2)
                                                    <strong>Opcion 3</strong> -
                                                    <strong>Contenedor</strong> -
                                                    <i class="fa fa-image" aria-hidden="true"></i>
                                                    <i class="fa fa-align-right" aria-hidden="true"></i>
                                                @endif
                                            </div>
                                        @endif 

                                        @if ($contenedor->titulo != null) 
                                            <strong>{{ $contenedor->titulo }}</strong>
                                        @endif
                                        <small>{{ Str::limit($contenedor->descripcion, 80) }}</small>
                                        
                                        <div style="display: flex; gap: 5px; flex-direction: row">
                                            @if ($contenedor->imagen != null)
                                                <img src="{{ asset('storage/' . $contenedor->imagen) }}" alt="Imagen" style="width: 100px; height: auto; object-fit: cover; margin-right: 10px;">
                                            @endif
                                            @if ($contenedor->video != null)
                                                <a href="{{ $contenedor->video }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-camera-video"></i> Ver video
                                                </a>
                                            @endif
                                        </div>
                                        
                                    </div>
                                    <div style="display: flex; gap: 5px; flex-direction: column;">
                                        @if (Auth::check() && Auth::user()->role == 'ADMIN')
                                            @if ($contenedor->status)
                                                <button class="btn btn-success btn-sm" title="Ver">
                                                    <i class="fa fa-eye"></i>
                                                    Activo
                                                </button>
                                            @else
                                                <button class="btn btn-secondary btn-sm" title="Inactivo" disabled>
                                                    <i class="fa fa-eye-slash"></i>
                                                    Inactivo
                                                </button>
                                            @endif
                                        @endif

                                        {{-- Botón Editar (puede abrir modal o ir a página de edición) --}}
                                        <a href="{{ route('contenido.edit', ['tipo' => 'evento', 'vista' => $evento->id, 'contenido' => $contenedor->id]) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                
                                        @if($contenedor->status)
                                            {{-- activo: mostrar eliminar --}}
                                            <form action="{{ route('contenido.destroy', ['tipo' => 'evento', 'vista' => $evento->id, 'contenido' => $contenedor->id]) }}" 
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('¿Eliminar este contenido?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        @else
                                            {{-- inactivo: mostrar restaurar --}}
                                            <form action="{{ route('contenido.activate', ['tipo' => 'evento', 'vista' => $evento->id, 'contenido' => $contenedor->id]) }}" 
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-success btn-sm">Restaurar</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No hay contenedores creados para este curso.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Modal -->
    <div class="modal fade" id="crearContenedorModal" tabindex="-1" aria-labelledby="crearContenedorLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="crearContenedorLabel">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>
                        Crear Contenedor
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contenido.store', ['tipo' => 'evento', 'vista' => $evento->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id_vista" value="{{ $evento->id }}">
                        <input type="hidden" name="vista_tipo" value="curso">
                        <!--
                        <div class="mb-3">
                            <label for="id_vista" class="form-label fw-bold">ID Vista</label>
                            <input type="number" class="form-control" id="id_vista" name="id_vista" required value="{{ $evento->id }}">
                        </div>

                        <div class="mb-3">
                            <label for="vista_tipo" class="form-label fw-bold">Vista Tipo</label>
                            <select name="vista_tipo" id="vista_tipo" class="form-select" required>
                                <option value="curso">Curso</option>
                                <option value="evento" selected>Evento</option>
                            </select>
                        </div> -->

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tipo</label><br>
                            <div class="btn-group" style="width: 100%;" role="group" aria-label="Tipo de contenido" require>
                                <input type="radio" class="btn-check" name="tipo" id="tipo-contenedor" value="contenedor" autocomplete="off" checked>
                                <label class="btn btn-outline-primary" for="tipo-contenedor">
                                    <i class="bi bi-layout-text-window"></i>
                                    Contenedor
                                </label>

                                <input type="radio" class="btn-check" name="tipo" id="tipo-columna" value="columna" autocomplete="off">
                                <label class="btn btn-outline-primary" for="tipo-columna">
                                    <i class="bi bi-columns"></i>
                                    Columna
                                </label>
                            </div>
                        </div>

                        <!-- Opciones Contenedor -->
                        <div id="opciones-contenedor" style="display:none; margin-top: 1rem;">
                            <label class="form-label fw-bold">Opciones Contenedor:</label><br>
                            <div class="btn-group" style="width: 100%" role="group">
                                <input type="radio" class="btn-check opcion-btn" name="opcion" id="cont-1" value="0" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="cont-1">
                                    <i class="fa fa-align-justify" aria-hidden="true"></i>
                                    1
                                </label>

                                <input type="radio" class="btn-check opcion-btn" name="opcion" id="cont-2" value="1" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="cont-2">
                                    <div>
                                        <i class="fa fa-align-left" aria-hidden="true"></i>
                                        <i class="fa fa-image" aria-hidden="true"></i>
                                    </div>
                                    2
                                </label>

                                <input type="radio" class="btn-check opcion-btn" name="opcion" id="cont-3" value="2" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="cont-3">
                                    <div>
                                        <i class="fa fa-image" aria-hidden="true"></i>
                                        <i class="fa fa-align-right" aria-hidden="true"></i>
                                    </div>
                                    3
                                </label>
                            </div>
                        </div>

                        <!-- Opciones Columna -->
                        <div id="opciones-columna" style="display:none; margin-top: 1rem;">
                            <label class="form-label fw-bold">Opciones Columna:</label><br>
                            <div class="btn-group" style="width: 100%" role="group">
                                
                                <input type="radio" class="btn-check opcion-btn" name="opcion" id="col-1" value="0" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="col-1">
                                    <i class="fa fa-list" aria-hidden="true"></i>
                                    1
                                </label>

                                <input type="radio" class="btn-check opcion-btn" name="opcion" id="col-2" value="1" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="col-2">
                                    <i class="fa fa-table" aria-hidden="true"></i>
                                    2
                                </label>
                            </div>
                        </div>

                        <div id="div-con-opciones" style="display:none; margin-top: 1rem;">
                            <label class="form-label fw-bold">
                                <i class="bi bi-pencil-square me-2"></i> Título:
                            </label>
                            <input type="text" name="titulo" maxlength="255" class="form-control mb-2">

                            <label class="form-label fw-bold">
                                <i class="bi bi-card-text me-2"></i> Descripción:
                            </label>
                            <textarea name="descripcion" class="form-control mb-2"></textarea>

                            <label class="form-label fw-bold">
                                <i class="bi bi-image me-2"></i> Imagen: (Opcional)
                            </label>
                            <input type="file" name="imagen" accept="image/*" class="form-control mb-2">

                            <label class="form-label fw-bold">
                                <i class="bi bi-camera-video me-2"></i> Video (URL): (Opcional)
                            </label>
                            <input type="text" name="video" maxlength="255" class="form-control">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<!--
<div class="modal-content-wrapper container py-4">

        <div class="card-body px-4 py-4">


            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-semibold">Nombre del Evento</label>
                    <input type="text" class="form-control shadow-sm" id="nombre" name="nombre"
                        value="{{ old('nombre', $evento->nombre) }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                    <textarea class="form-control shadow-sm" id="descripcion" name="descripcion" rows="4"
                        required>{{ old('descripcion', $evento->descripcion) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="foto" class="form-label fw-semibold">Imagen del Evento</label>
                    <input type="file" class="form-control shadow-sm" id="foto" name="foto" accept="image/*">
                    @if ($evento->foto)
                        <div class="mt-3">
                            <p class="mb-1 text-muted">Imagen actual:</p>
                            <img src="{{ asset('storage/' . $evento->foto) }}" alt="Imagen del evento"
                                class="img-thumbnail rounded" style="max-width: 200px;">
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success shadow-sm">
                        <i class="fas fa-save me-1"></i>Actualizar
                    </button>
                    <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary shadow-sm">
                        Cancelar
                    </a>
                </div>
            </form>

        </div>

</div>
-->

<script>
  const tipoContenedor = document.getElementById('tipo-contenedor');
  const tipoColumna = document.getElementById('tipo-columna');

  const opcionesContenedor = document.getElementById('opciones-contenedor');
  const opcionesColumna = document.getElementById('opciones-columna');

  const divConOpciones = document.getElementById('div-con-opciones');

  // Muestra/oculta opciones según tipo seleccionado
  function mostrarOpciones() {
    divConOpciones.style.display = 'none'; // oculta al cambiar tipo
    if(tipoContenedor.checked) {
      opcionesContenedor.style.display = 'block';
      opcionesColumna.style.display = 'none';

      // Desmarca todas las opciones de columna
      document.querySelectorAll('input[name="opcion-columna"]').forEach(i => i.checked = false);
    } else if(tipoColumna.checked) {
      opcionesContenedor.style.display = 'none';
      opcionesColumna.style.display = 'block';

      // Desmarca todas las opciones de contenedor
      document.querySelectorAll('input[name="opcion-contenedor"]').forEach(i => i.checked = false);
    }
  }

  // Detecta cambio de tipo
  tipoContenedor.addEventListener('change', mostrarOpciones);
  tipoColumna.addEventListener('change', mostrarOpciones);

  // Cuando se selecciona alguna opción (contenedor o columna), mostrar el div extra
  document.querySelectorAll('.opcion-btn').forEach(radio => {
    radio.addEventListener('change', () => {
      if(radio.checked) {
        divConOpciones.style.display = 'block';
      }
    });
  });

  // Al cargar la página mostrar las opciones del tipo seleccionado
  mostrarOpciones();
</script>

<style>
  .btn-group .btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.25rem; /* espacio entre icono y texto */
    padding: 1rem 1.5rem;
  }

  .btn-group .btn i {
    font-size: 2.5rem; /* ícono más grande */
    line-height: 1;
  }
</style>