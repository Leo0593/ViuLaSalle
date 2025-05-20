@include('layouts.head')

<body class="bg-light">
    @include('layouts.navheader')

    <div class="container py-5" style="max-width: 800px;">

        <!-- Tarjeta principal con sombra y bordes redondeados -->
        <div class="body-container hero-section p-4 mb-4 rounded-4 shadow-sm"
            style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);">
            <div class="card-body p-4 p-lg-5">
                <!-- Encabezado con mejor jerarquía visual -->
                <div class="text-center mb-5">
                    <i class="fas fa-camera-retro text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <h1 class="h3 fw-bold text-dark mb-2">Crear Publicación de Colección</h1>
                    <p class="text-muted">Comparte los detalles de tu colección con la comunidad</p>
                </div>

                {{-- Mostrar errores con mejor diseño --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong class="me-2">Corrige estos errores:</strong>
                        </div>
                        <ul class="mb-0 mt-2 ps-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                <form action="{{ route('publicacioncolecciones.store') }}" method="POST" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="coleccion_id" value="{{ $coleccion_id }}">

                    {{-- Descripción --}}
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold text-dark mb-2">Descripción <span
                                class="text-danger">*</span></label>
                        <textarea id="descripcion" name="descripcion" rows="5" class="form-control border-2 py-3 px-3"
                            style="border-color: #e9ecef; border-radius: 12px;" placeholder="Describe tu publicación..."
                            required>{{ old('descripcion') }}</textarea>
                        <div class="invalid-feedback mt-1">Por favor escribe una descripción.</div>
                    </div>

                    {{-- Fotos --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark mb-2 d-block">
                            <i class="fas fa-images me-2 text-primary"></i> Subir Fotos
                        </label>

                        <div class="d-flex align-items-center mb-3">
                            <label for="fotos" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm me-3">
                                <i class="fas fa-cloud-upload-alt me-2"></i> Seleccionar Fotos
                                <input type="file" name="fotos[]" id="fotos" class="d-none" multiple accept="image/*">
                            </label>
                            <small class="text-muted">Formatos: JPG, PNG. Máx. 5MB por imagen.</small>
                        </div>

                        <!-- Previsualización con mejor diseño -->
                        <div class="d-flex flex-wrap gap-3 mt-3" id="preview-container"></div>
                    </div>

                    {{-- Botón de publicación --}}
                    <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm fw-semibold">
                            <i class="fas fa-paper-plane me-2"></i> Publicar Colección
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Scripts (sin cambios) --}}
    <script>
        (function () {
            'use strict';
            // Validación de formulario bootstrap
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

        // Manejo de selección y eliminación de imágenes
        let selectedFiles = [];

        document.getElementById('fotos').addEventListener('change', function (e) {
            // Agrega los nuevos archivos a selectedFiles
            selectedFiles = [...selectedFiles, ...Array.from(this.files)];

            // Limitar a máximo 10 imágenes (opcional)
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
                    deleteBtn.style.zIndex = '10';
                    deleteBtn.onclick = (e) => {
                        e.preventDefault();
                        e.stopPropagation();
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

</html>