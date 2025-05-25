@include('layouts.head') {{-- Asegúrate de tener Bootstrap en tu head --}}

<body class="bg-light text-dark">
    @include('layouts.navheader')

    <div class="margin-top-header container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Perfil --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Información del Perfil
                    </div>
                    <div class="card-body">
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                       class="form-control @error('name') is-invalid @enderror" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                       class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-2 alert alert-warning">
                                        Tu correo no está verificado.
                                        <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">
                                            Haz clic aquí para reenviar el correo de verificación.
                                        </button>
                                        @if (session('status') === 'verification-link-sent')
                                            <div class="mt-2 text-success">
                                                Se ha enviado un nuevo enlace de verificación.
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button class="btn btn-success" type="submit">Guardar</button>
                                @if (session('status') === 'profile-updated')
                                    <div class="text-success">Guardado.</div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Contraseña --}}
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        Cambiar Contraseña
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label" for="current_password">Contraseña Actual</label>
                                <input type="password" id="current_password" name="current_password"
                                       class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password">Nueva Contraseña</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror">
                                @error('password_confirmation', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button class="btn btn-success" type="submit">Guardar</button>
                                @if (session('status') === 'password-updated')
                                    <div class="text-success">Guardado.</div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Eliminar Cuenta --}}
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        Eliminar Cuenta
                    </div>
                    <div class="card-body">
                        <p>
                            Una vez que se elimine tu cuenta, todos los datos se borrarán permanentemente.
                        </p>
                        <button class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#confirmDeletionModal">
                            Eliminar Cuenta
                        </button>
                    </div>
                </div>

                <!-- Modal de confirmación -->
                <div class="modal fade" id="confirmDeletionModal" tabindex="-1" aria-labelledby="confirmDeletionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
                            @csrf
                            @method('delete')

                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeletionModalLabel">¿Eliminar cuenta?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>

                            <div class="modal-body">
                                <p>
                                    Esta acción eliminará todos tus datos permanentemente. Escribe tu contraseña para confirmar.
                                </p>
                                <input type="password" name="password" placeholder="Contraseña" class="form-control @error('password', 'userDeletion') is-invalid @enderror">
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Eliminar Cuenta</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (para modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
