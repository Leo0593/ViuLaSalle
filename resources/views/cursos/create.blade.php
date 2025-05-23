@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container py-4 margin-top-header">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
    
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 text-dark fw-bold">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Crear curso
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Error en el formulario</h5>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Columna izquierda - Datos básicos -->
                        <div class="col-md-6">
                            <!-- Nivel educativo -->
                            <div class="mb-4">
                                <label for="id_nivel" class="form-label fw-bold text-dark mb-2">
                                    <i class="fas fa-layer-group me-2 text-primary"></i>Nivel educativo
                                </label>
                                <select name="id_nivel" id="id_nivel" class="form-select shadow-sm py-2" required>
                                    <option value="" selected disabled>Selecciona un nivel educativo</option>
                                    @foreach($niveles as $nivel)
                                        <option value="{{ $nivel->id }}" {{ old('id_nivel') == $nivel->id ? 'selected' : '' }}>
                                            {{ $nivel->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Este campo es obligatorio</div>
                            </div>

                            <!-- Nombre del curso -->
                            <div class="mb-4">
                                <label for="nombre" class="form-label fw-bold text-dark mb-2">
                                    <i class="fas fa-book me-2 text-primary"></i>Nombre del curso
                                </label>
                                <input type="text" name="nombre" id="nombre" class="form-control shadow-sm py-2" 
                                    value="{{ old('nombre') }}" maxlength="255" placeholder="Ej: Matemáticas Básicas" required>
                                <div class="invalid-feedback">Por favor ingresa un nombre válido</div>
                                <small class="text-muted">Máximo 255 caracteres</small>
                            </div>
                        </div>

                        <!-- Columna derecha - Archivos -->
                        <div class="col-md-6">
                            <!-- Imagen del curso -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark mb-2">
                                    <i class="fas fa-image me-2 text-primary"></i>Portada del curso
                                </label>
                                <div class="file-upload-container border rounded-3 p-3 text-center">
                                    <div id="image-preview-container" class="mb-2">
                                        <img id="image-preview" src="#" alt="Previsualización" 
                                            class="img-fluid rounded" style="display: none; max-height: 150px;">
                                        <div id="empty-image" class="py-4">
                                            <i class="fas fa-image text-muted fs-1 mb-2"></i>
                                            <p class="text-muted mb-0">No hay imagen seleccionada</p>
                                        </div>
                                    </div>
                                    <label for="img" class="btn btn-outline-primary rounded-pill px-4">
                                        <i class="fas fa-upload me-2"></i> Subir imagen
                                        <input type="file" name="img" id="img" class="d-none" accept="image/*">
                                    </label>
                                    <div class="mt-2">
                                        <small class="text-muted">Formatos: JPG, PNG (Recomendado: 800x450px)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PDF del curso -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-file-pdf me-2 text-primary"></i>Material del curso (PDF)
                        </label>
                        <div class="file-upload-container border rounded-3 p-3">
                            <div id="pdf-preview-container" class="d-flex align-items-center justify-content-between mb-3">
                                <div id="pdf-preview" style="display: none;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger me-3 fs-2"></i>
                                        <div>
                                            <h6 class="mb-0" id="pdf-name"></h6>
                                            <small class="text-muted" id="pdf-size"></small>
                                        </div>
                                    </div>
                                </div>
                                <div id="empty-pdf" class="text-center w-100 py-2">
                                    <i class="fas fa-file-upload text-muted fs-1 mb-2"></i>
                                    <p class="text-muted mb-0">No hay archivo seleccionado</p>
                                </div>
                            </div>
                            <label for="pdf" class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fas fa-upload me-2"></i> Subir PDF
                                <input type="file" name="pdf" id="pdf" class="d-none" accept="application/pdf">
                            </label>
                            <div class="mt-2">
                                <small class="text-muted">Tamaño máximo: 25MB • Formatos: PDF</small>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Guardar curso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>


<!-- Script para previsualización de archivos -->
<script>
    // Previsualización de imagen
    document.getElementById('img').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const empty = document.getElementById('empty-image');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                empty.style.display = 'none';
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            preview.src = '#';
            empty.style.display = 'block';
        }
    });
    
    // Previsualización de PDF
    document.getElementById('pdf').addEventListener('change', function(e) {
        const preview = document.getElementById('pdf-preview');
        const empty = document.getElementById('empty-pdf');
        const pdfName = document.getElementById('pdf-name');
        const pdfSize = document.getElementById('pdf-size');
        const file = e.target.files[0];
        
        if (file) {
            pdfName.textContent = file.name;
            pdfSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            preview.style.display = 'flex';
            empty.style.display = 'none';
        } else {
            preview.style.display = 'none';
            pdfName.textContent = '';
            pdfSize.textContent = '';
            empty.style.display = 'block';
        }
    });
</script>

<style>
    .file-upload-container {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    .file-upload-container:hover {
        background-color: #f1f3f5;
    }
    .form-select, .form-control {
        border-radius: 8px !important;
        padding: 10px 15px !important;
    }
</style>