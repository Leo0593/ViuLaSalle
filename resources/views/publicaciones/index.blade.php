@include('layouts.head')

<body>

    @include('layouts.navheader')

    <div class="container py-4">
        <!-- Hero Section -->
        <div class="body-container hero-section p-4">
            <div class="container text-center">
                <h1 class="display-5 fw-bold">Gestión de Publicaciones</h1>
                <p class="lead">Aquí puedes ver, crear y editar eventos registrados en el sistema.</p>
            </div>
        </div>

        <!-- Header with Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Listado de Publicaciones</h2>
            <div class="action-buttons">
                <a href="{{ route('publicaciones.create') }}" class="btn btn-primary create-btn">
                    <i class="fas fa-plus me-2"></i>Crear Publicación
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver a Dashboard
                </a>
            </div>
        </div>

        <!-- Publications Grid -->
        <div class="row">
            @foreach($publicaciones as $publicacion)
                <div class="col-lg-6 col-xl-4">
                    <div class="publication-card">
                        <!-- Card Header -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span
                                class="badge status-badge {{ $publicacion->status == 1 ? 'status-active' : 'status-inactive' }}">
                                {{ $publicacion->status == 1 ? 'Activo' : 'Inactivo' }}
                            </span>
                            <small class="date-text">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ $publicacion->fecha_publicacion->format('d/m/Y') }}
                            </small>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <!-- User Info -->
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ substr($publicacion->usuario->name, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $publicacion->usuario->name }}</h6>
                                    <small class="text-muted">
                                        @if($publicacion->evento)
                                            Evento: {{ $publicacion->evento->nombre }}
                                        @else
                                            Sin evento asociado
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="mb-3">{{ $publicacion->descripcion }}</p>

                            <!-- Media Grid (Fotos y Videos combinados) -->
                            @if($publicacion->fotos->count() > 0 || $publicacion->videos->count() > 0)
                                <div class="media-grid">
                                    @foreach($publicacion->fotos as $foto)
                                        <div class="media-item" data-bs-toggle="modal" data-bs-target="#mediaModal"
                                            data-type="image"
                                            data-src="{{ Storage::url('public/publicaciones/' . $foto->ruta_foto) }}">
                                            <img src="{{ Storage::url('public/publicaciones/' . $foto->ruta_foto) }}"
                                                alt="Foto de publicación">
                                        </div>
                                    @endforeach

                                    @foreach($publicacion->videos as $video)
                                        <div class="media-item video-item" data-bs-toggle="modal" data-bs-target="#mediaModal"
                                            data-type="video" data-src="{{ Storage::url('publicvideos/' . $video->ruta_video) }}">
                                            <video>
                                                <source src="{{ Storage::url('publicvideos/' . $video->ruta_video) }}"
                                                    type="video/mp4">
                                            </video>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="no-content">No hay medios en esta publicación</div>
                            @endif

                            <!-- Categories -->
                            @if($publicacion->categorias->count() > 0)
                                <h6 class="mt-3 mb-2">Categorías:</h6>
                                <div>
                                    @foreach($publicacion->categorias as $categoria)
                                        <span class="category-badge">{{ $categoria->nombre }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer">
                            <!-- Like Button -->
                            <button
                                class="btn-like {{ Auth::check() && $publicacion->isLikedByUser(Auth::id()) ? 'liked' : '' }}"
                                data-id="{{ $publicacion->id }}">
                                <i class="fas fa-heart me-1"></i>
                                <span class="like-count">{{ $publicacion->likes }}</span>
                            </button>

                            <!-- Actions -->
                            <div class="action-buttons">
                                <!-- Report Button -->
                                @php
                                    $yaReportado = \App\Models\Reporte::where('user_id', auth()->id())
                                        ->where('publicacion_id', $publicacion->id)
                                        ->exists();
                                @endphp

                                @if (!$yaReportado)
                                    <form action="{{ route('publicaciones.reportar', $publicacion->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            <i class="fas fa-flag"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        <i class="fas fa-flag"></i>
                                    </button>
                                @endif

                                <!-- Comments Button -->
                                @if($publicacion->activar_comentarios == 1)
                                    <a href="{{ route('comentarios.ver', $publicacion->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-comments"></i>
                                    </a>
                                @endif

                                <!-- Edit/Delete Buttons (for owners/admins) -->
                                @if($user->role == 'ADMIN' || $publicacion->id_user === auth()->id())
                                    <a href="{{ route('publicaciones.edit', $publicacion->id) }}"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    @if ($publicacion->status == 1)
                                        <form action="{{ route('publicaciones.destroy', $publicacion->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Estás seguro de que deseas desactivar esta publicación?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('publicaciones.activate', $publicacion->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-success"
                                                onclick="return confirm('¿Estás seguro de que deseas activar esta publicación?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal para visualización de medios -->
    <div class="modal fade media-modal" id="mediaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenido dinámico se insertará aquí -->
                </div>
            </div>
        </div>
    </div>



</body>

<script>
    // Like button functionality
    document.querySelectorAll('.btn-like').forEach(button => {
        button.addEventListener('click', function () {
            const publicationId = this.getAttribute('data-id');
            const likeCount = this.querySelector('.like-count');

            // Aquí iría tu lógica AJAX para manejar los likes
            console.log(`Like a publicación ${publicationId}`);

            // Ejemplo de cambio visual
            this.classList.toggle('liked');
            const currentLikes = parseInt(likeCount.textContent);
            likeCount.textContent = this.classList.contains('liked') ? currentLikes + 1 : currentLikes - 1;
        });
    });

    // Media Modal functionality
    const mediaModal = document.getElementById('mediaModal');
    if (mediaModal) {
        mediaModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const mediaType = button.getAttribute('data-type');
            const mediaSrc = button.getAttribute('data-src');
            const modalBody = mediaModal.querySelector('.modal-body');

            modalBody.innerHTML = '';

            if (mediaType === 'image') {
                modalBody.innerHTML = `<img src="${mediaSrc}" class="img-fluid" alt="Media ampliada">`;
            } else if (mediaType === 'video') {
                modalBody.innerHTML = `
                        <video controls autoplay class="img-fluid">
                            <source src="${mediaSrc}" type="video/mp4">
                            Tu navegador no soporta el video.
                        </video>
                    `;
            }
        });

        // Pausar video cuando se cierra el modal
        mediaModal.addEventListener('hidden.bs.modal', function () {
            const video = mediaModal.querySelector('video');
            if (video) {
                video.pause();
            }
        });
    }
</script>

<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #f8f9fc;
        --accent-color: #2e59d9;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
        color: white;
        border-radius: 0.5rem;
        padding: 3rem 0;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .publication-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .publication-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: var(--secondary-color);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-body {
        padding: 1.5rem;
    }

    .user-info {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
        background-color: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-weight: bold;
    }

    /* Media Grid - 5 columnas */
    .media-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 8px;
        margin: 1rem 0;
    }

    .media-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1/1;
        background-color: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .media-item img,
    .media-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .media-item:hover img,
    .media-item:hover video {
        transform: scale(1.05);
    }

    .media-item.video-item::after {
        content: '\f04b';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        color: white;
        font-size: 1.5rem;
        background: rgba(0, 0, 0, 0.5);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .category-badge {
        display: inline-block;
        background-color: #e9ecef;
        color: #495057;
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        font-size: 0.75rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-like {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .btn-like.liked {
        color: #dc3545;
    }

    .status-badge {
        padding: 0.35rem 0.65rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-active {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .comments-toggle {
        background-color: #e0f2fe;
        color: #0369a1;
    }

    .no-content {
        color: #6c757d;
        font-style: italic;
        padding: 2rem 0;
        text-align: center;
        grid-column: 1 / -1;
    }

    .card-footer {
        background-color: var(--secondary-color);
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .date-text {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .create-btn {
        background-color: var(--primary-color);
        border: none;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
    }

    .create-btn:hover {
        background-color: var(--accent-color);
    }

    /* Modal para medios */
    .media-modal .modal-content {
        background-color: transparent;
        border: none;
    }

    .media-modal .modal-body {
        padding: 0;
        text-align: center;
    }

    .media-modal .modal-body img,
    .media-modal .modal-body video {
        max-height: 80vh;
        max-width: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .media-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 992px) {
        .media-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .media-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .media-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@include('layouts.footer')