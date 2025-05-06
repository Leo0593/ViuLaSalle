<div class="modal-content-wrapper container px-4 py-3">
    <div class="card-body px-0">
        <!-- Encabezado -->
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <span class="badge bg-light text-primary mb-2">
                    <i class="fas fa-bell me-1"></i> Notificación
                </span>
                <h3 class="fw-bold mb-1">{{ $notificacion->titulo }}</h3>
                <p class="text-muted mb-0">
                    <small>Enviada el {{ $notificacion->created_at->format('d/m/Y \a \l\a\s H:i') }}</small>
                </p>
            </div>
            <span class="badge bg-{{ $notificacion->es_global ? 'success' : 'info' }} rounded-pill px-3 py-2">
                {{ $notificacion->es_global ? 'Global' : 'Personalizada' }}
            </span>
        </div>

        <!-- Mensaje -->
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-2 d-flex align-items-center">
                <i class="fas fa-envelope-open-text me-2"></i> Mensaje
            </h6>
            <div class="bg-light p-4 rounded-3 border-start border-4 border-primary">
                <p class="mb-0 text-dark" style="line-height: 1.6;">{{ $notificacion->mensaje }}</p>
            </div>
        </div>

        <!-- Destinatarios (si aplica) -->
        @if (!$notificacion->es_global)
            <div class="mb-3">
                <h6 class="text-uppercase text-muted small mb-2 d-flex align-items-center">
                    <i class="fas fa-users me-2"></i> Destinatarios ({{ count($notificacion->destinatarios) }})
                </h6>
                <div class="bg-light p-3 rounded-3 border" style="max-height: 250px; overflow-y: auto;">
                    <ul class="list-group list-group-flush">
                        @foreach ($notificacion->destinatarios as $usuario)
                            <li class="list-group-item bg-transparent px-3 py-3 d-flex justify-content-between align-items-center hover-light">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        {{ substr($usuario->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $usuario->name }}</div>
                                        <small class="text-muted">{{ $usuario->email }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-secondary rounded-pill">#{{ $usuario->id }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
