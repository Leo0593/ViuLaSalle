@include('layouts.head')

<body class="bg-light">
    @include('layouts.navheader')
    <div class="container py-5" style="max-width: 800px;">
        <div class="body-container hero-section p-4 mb-4 rounded-4 shadow-sm"
            style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);">
            <div class="card-body p-4 p-lg-5">
                <div class="text-center mb-5">
                    <i class="fas fa-edit text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <h1 class="h3 fw-bold text-dark mb-2">Editar Publicación</h1>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-2">
                        <ul class="mb-0 mt-2 ps-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('publicacioncolecciones.update', $publicacion->id) }}"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Descripción --}}
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold text-dark mb-2">Descripción <span
                                class="text-danger">*</span></label>
                        <textarea id="descripcion" name="descripcion" rows="5" class="form-control border-2 py-3 px-3"
                            required>{{ old('descripcion', $publicacion->descripcion) }}</textarea>
                        <div class="invalid-feedback mt-1">Por favor escribe una descripción.</div>
                    </div>

                    {{-- Fotos actuales --}}
                    @if ($publicacion->fotos && count($publicacion->fotos))
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2 d-block">Fotos actuales</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($publicacion->fotos as $foto)
                                    <div style="width: 120px; position: relative;">
                                        <img src="{{ asset('storage/' . $foto->ruta_foto) }}" class="img-thumbnail rounded"
                                            style="width: 100%; height: 100px; object-fit: cover;">
                                        <div class="form-check mt-2 text-center">
                                            <input class="form-check-input" type="checkbox" name="fotos_eliminar[]"
                                                value="{{ $foto->id }}">
                                            <label class="form-check-label small text-danger">Eliminar</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Subir nuevas fotos --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark mb-2 d-block">
                            <i class="fas fa-images me-2 text-primary"></i> Agregar nuevas fotos
                        </label>

                        <div class="d-flex align-items-center mb-3">
                            <label for="fotos" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm me-3">
                                <i class="fas fa-cloud-upload-alt me-2"></i> Seleccionar Fotos
                                <input type="file" name="fotos[]" id="fotos" class="d-none" multiple accept="image/*">
                            </label>
                            <small class="text-muted">Formatos: JPG, PNG. Máx. 5MB por imagen.</small>
                        </div>

                        <!-- Contenedor para previsualizar imágenes -->
                        <div class="d-flex flex-wrap gap-3 mt-3" id="preview-container"></div>
                    </div>

                    {{-- Botón de actualizar --}}
                    <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                        <button type="submit" class="btn btn-success rounded-pill px-4 py-2 shadow-sm fw-semibold">
                            <i class="fas fa-save me-2"></i> Actualizar Publicación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Validación del formulario
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Previsualización de imágenes
        let selectedFiles = [];

        document.getElementById('fotos').addEventListener('change', function (e) {
            selectedFiles = [...selectedFiles, ...Array.from(this.files)];
            if (selectedFiles.length > 10) {
                selectedFiles = selectedFiles.slice(0, 10);
                alert('Solo puedes seleccionar un máximo de 10 fotos.');
            }
            renderPreviews();
        });

        function renderPreviews() {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const previewWrapper = document.createElement('div');
                    previewWrapper.className = 'position-relative';
                    previewWrapper.style.width = '120px';
                    previewWrapper.style.height = '120px';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'img-thumbnail rounded';
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';

                    const deleteBtn = document.createElement('button');
                    deleteBtn.innerHTML = '&times;';
                    deleteBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0 m-1';
                    deleteBtn.onclick = (e) => {
                        e.preventDefault();
                        removeImage(index);
                    };

                    previewWrapper.appendChild(img);
                    previewWrapper.appendChild(deleteBtn);
                    previewContainer.appendChild(previewWrapper);
                }
            });

            updateFileInput();
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);
            renderPreviews();
        }

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('fotos').files = dataTransfer.files;
        }
    </script>
</body>