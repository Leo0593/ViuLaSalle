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
