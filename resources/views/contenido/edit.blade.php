@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container py-4 margin-top-header">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 text-dark fw-bold">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    Editando Contenido: 
                    <span class="badge bg-secondary">{{ $contenido->titulo }}</span>
                    <span class="badge bg-secondary">{{ $contenido->tipo }}</span>
                    <span class="badge bg-secondary">{{ $contenido->vista_tipo }}</span>
                    <span class="badge bg-secondary">Vista ID: {{ $contenido->id_vista }}</span>
                    <span class="badge bg-secondary">Opción: {{ $contenido->opcion }}</span>
                    <span class="badge bg-secondary">ID: {{ $contenido->id }}</span>
                </h5>
            </div>

            <div class="card-body p-4">
                @php
                    $rutaUpdate = route('contenido.update', [
                        'tipo' => $contenido->vista_tipo, 
                        'vista' => $contenido->id_vista, 
                        'contenido' => $contenido->id
                    ]);
                @endphp

                <form action="{{ $rutaUpdate }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id_vista" value="{{ $contenido->id_vista }}">
                    <input type="hidden" name="vista_tipo" value="{{ $contenido->vista_tipo }}">

                    <div class="mb-4">
                        <label for="tipo" class="form-label fw-semibold">
                            <i class="bi bi-list-ul me-2"></i>Tipo
                        </label>
                        <select name="tipo" id="tipo" class="form-select" required>
                            <option value="contenedor" {{ old('tipo', $contenido->tipo) == 'contenedor' ? 'selected' : '' }}>Contenedor</option>
                            <option value="columna" {{ old('tipo', $contenido->tipo) == 'columna' ? 'selected' : '' }}>Columna</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="titulo" class="form-label fw-semibold">
                            <i class="bi bi-pencil-square me-2"></i>Título
                        </label>
                        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $contenido->titulo) }}" class="form-control shadow-sm" maxlength="255">
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold">
                            <i class="bi bi-card-text me-2"></i>Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion" class="form-control shadow-sm" rows="3">{{ old('descripcion', $contenido->descripcion) }}</textarea>
                    </div>

                    {{-- Imagen actual --}}
                    @if ($contenido->imagen)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Imagen actual:</label>
                            <div class="d-flex align-items-center gap-2 p-2 border rounded bg-light">
                                <img src="{{ asset('storage/' . $contenido->imagen) }}" alt="Imagen actual" class="img-thumbnail rounded" style="max-width: 200px;">
                            </div>
                        </div>
                    @endif

                    {{-- Nueva imagen --}}
                    <div class="mb-4">
                        <label for="imagen" class="form-label fw-semibold">
                            <i class="bi bi-image me-2"></i>Nueva imagen (opcional)
                        </label>
                        <input type="file" name="imagen" id="imagen" class="form-control shadow-sm" accept="image/*">
                    </div>

                    {{-- Video actual --}}
                    @if ($contenido->video)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Video actual:</label>
                            <div class="p-2 border rounded bg-light" style="max-width: 320px;">
                                @php
                                    $videoUrl = $contenido->video;
                                @endphp

                                @if(Str::endsWith($videoUrl, ['.mp4', '.webm', '.ogg']))
                                    <video controls class="w-100" style="max-height: 180px;">
                                        <source src="{{ $videoUrl }}" type="video/mp4">
                                        Tu navegador no soporta la reproducción de videos.
                                    </video>
                                @else
                                    {{-- Si es URL tipo embed (YouTube, Vimeo, etc) --}}
                                    <iframe width="100%" height="180" src="{{ $videoUrl }}" frameborder="0" allowfullscreen></iframe>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Nueva URL video --}}
                    <div class="mb-4">
                        <label for="video" class="form-label fw-semibold">
                            <i class="bi bi-camera-video me-2"></i>URL Video (opcional)
                        </label>
                        <input type="text" name="video" id="video" value="{{ old('video', $contenido->video) }}" class="form-control shadow-sm" maxlength="255">
                    </div>

                    {{-- Opción por número solo si no se usan radios (respaldo) --}}
                    
                    <input type="hidden" name="opcion" id="opcion" value="{{ old('opcion', $contenido->opcion) }}" class="form-control shadow-sm" required>
                    <!-- <div class="mb-4">
                        <label for="opcion" class="form-label fw-semibold">
                            <i class="bi bi-list-check me-2"></i>Opción
                        </label>
                    </div> -->

                    {{-- Opciones tipo contenedor --}}
                    <div id="opciones-contenedor" style="display:none; margin-top: 1rem;">
                        <label class="form-label fw-bold">Opciones Contenedor:</label><br>
                        <div class="btn-group" style="width: 100%" role="group">
                            @for ($i = 0; $i <= 2; $i++)
                                <input type="radio" class="btn-check opcion-btn" name="opcion" id="cont-{{ $i+1 }}" value="{{ $i }}" autocomplete="off"
                                    {{ old('opcion', $contenido->opcion) == $i && old('tipo', $contenido->tipo) == 'contenedor' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary" for="cont-{{ $i+1 }}">
                                    @if ($i == 0)
                                        <i class="fa fa-align-justify" aria-hidden="true"></i> 1
                                    @elseif ($i == 1)
                                        <div><i class="fa fa-align-left"></i><i class="fa fa-image"></i> 2</div>
                                    @else
                                        <div><i class="fa fa-image"></i><i class="fa fa-align-right"></i> 3</div>
                                    @endif
                                </label>
                            @endfor
                        </div>
                    </div>

                    {{-- Opciones tipo columna --}}
                    <div id="opciones-columna" style="display:none; margin-top: 1rem;">
                        <label class="form-label fw-bold">Opciones Columna:</label><br>
                        <div class="btn-group" style="width: 100%" role="group">
                            @for ($i = 0; $i <= 1; $i++)
                                <input type="radio" class="btn-check opcion-btn" name="opcion" id="col-{{ $i+1 }}" value="{{ $i }}" autocomplete="off"
                                    {{ old('opcion', $contenido->opcion) == $i && old('tipo', $contenido->tipo) == 'columna' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary" for="col-{{ $i+1 }}">
                                    @if ($i == 0)
                                        <i class="fa fa-list" aria-hidden="true"></i> 1
                                    @else
                                        <i class="fa fa-table" aria-hidden="true"></i> 2
                                    @endif
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('contenido.index') }}" class="btn btn-outline-secondary shadow-sm">Cancelar</a>
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="bi bi-save me-1"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.getElementById('tipo');
        const contenedor = document.getElementById('opciones-contenedor');
        const columna = document.getElementById('opciones-columna');

        function toggleOpciones() {
            if (tipoSelect.value === 'contenedor') {
                contenedor.style.display = 'block';
                columna.style.display = 'none';
            } else if (tipoSelect.value === 'columna') {
                columna.style.display = 'block';
                contenedor.style.display = 'none';
            } else {
                contenedor.style.display = 'none';
                columna.style.display = 'none';
            }
        }

        tipoSelect.addEventListener('change', toggleOpciones);
        toggleOpciones(); // inicializar al cargar
    });
</script>