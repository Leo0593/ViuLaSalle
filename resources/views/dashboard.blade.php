@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="container mt-5 pt-5">

        <div class="container mt-4 pt-4"> </div>

        <div class="bg-light p-4 rounded-4 mb-4 shadow-sm text-center my-5 ">
            <h1 class="text-2xl font-bold text-gray-800">Panel de Administración</h1>
            <div class="mt-4">
                <p class="text-gray-600">Bienvenido al panel de administración. Aquí puedes gestionar los usuarios,
                    eventos,
                    publicaciones, categorías, niveles educativos y cursos.</p>
            </div>
        </div>



        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 ">
            <div class="row">
                <!-- Tarjeta Usuarios -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                        <div class="card-img-top d-flex align-items-center justify-content-center p-4"
                            style="background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            <i class="fa-solid fa-users" style="font-size: 80px; color: #6c757d;"></i>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-3" style="font-size: 1.25rem; font-weight: 600;">Usuarios</h5>
                            <a href="{{ route('users.index') }}" class="btn btn-primary px-4 py-2"
                                style="border-radius: 50px; font-size: 1rem;">
                                Gestionar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Eventos -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                        <div class="card-img-top d-flex align-items-center justify-content-center p-4"
                            style="background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            <i class="fa-solid fa-calendar-days" style="font-size: 80px; color: #6c757d;"></i>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-3" style="font-size: 1.25rem; font-weight: 600;">Eventos</h5>
                            <a href="{{ route('eventos.index') }}" class="btn btn-primary px-4 py-2"
                                style="border-radius: 50px; font-size: 1rem;">
                                Gestionar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Publicaciones -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                        <div class="card-img-top d-flex align-items-center justify-content-center p-4"
                            style="background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            <i class="fa-solid fa-newspaper" style="font-size: 80px; color: #6c757d;"></i>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-3" style="font-size: 1.25rem; font-weight: 600;">Publicaciones</h5>
                            <a href="{{ route('publicaciones.index') }}" class="btn btn-primary px-4 py-2"
                                style="border-radius: 50px; font-size: 1rem;">
                                Gestionar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Categorías -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                        <div class="card-img-top d-flex align-items-center justify-content-center p-4"
                            style="background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            <i class="fa-solid fa-tags" style="font-size: 80px; color: #6c757d;"></i>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-3" style="font-size: 1.25rem; font-weight: 600;">Categorías</h5>
                            <a href="{{ route('categorias.index') }}" class="btn btn-primary px-4 py-2"
                                style="border-radius: 50px; font-size: 1rem;">
                                Gestionar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Niveles Educativos -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                        <div class="card-img-top d-flex align-items-center justify-content-center p-4"
                            style="background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            <i class="fa-solid fa-graduation-cap" style="font-size: 80px; color: #6c757d;"></i>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-3" style="font-size: 1.25rem; font-weight: 600;">Niveles Educativos
                            </h5>
                            <a href="{{ route('niveles.index') }}" class="btn btn-primary px-4 py-2"
                                style="border-radius: 50px; font-size: 1rem;">
                                Gestionar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Cursos -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                        <div class="card-img-top d-flex align-items-center justify-content-center p-4"
                            style="background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            <i class="fa-solid fa-book-open" style="font-size: 80px; color: #6c757d;"></i>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-3" style="font-size: 1.25rem; font-weight: 600;">Cursos</h5>
                            <a href="{{ route('cursos.index') }}" class="btn btn-primary px-4 py-2"
                                style="border-radius: 50px; font-size: 1rem;">
                                Gestionar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta notificaciones -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                        <div class="card-img-top d-flex align-items-center justify-content-center p-4"
                            style="background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            <i class="fa-solid fa-bell" style="font-size: 80px; color: #6c757d;"></i>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-3" style="font-size: 1.25rem; font-weight: 600;">Notificaciones
                            </h5>
                            <a href="{{ route('notificaciones.index') }}" class="btn btn-primary px-4 py-2"
                                style="border-radius: 50px; font-size: 1rem;">
                                Gestionar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta colleciones -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                        <div class="card-img-top d-flex align-items-center justify-content-center p-4"
                            style="background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            <i class="fa-solid fa-users" style="font-size: 80px; color: #6c757d;"></i>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-3" style="font-size: 1.25rem; font-weight: 600;">Grupos
                            </h5>
                            <a href="{{ route('colecciones.index') }}" class="btn btn-primary px-4 py-2"
                                style="border-radius: 50px; font-size: 1rem;">
                                Gestionar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Retornar -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0" style="border-radius: 20px !important;">
                        <div class="card-img-top d-flex align-items-center justify-content-center p-4"
                            style="background-color: #f0f0f0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
                            <i class="fa-solid fa-door-open" style="font-size: 80px; color: #6c757d;"></i>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-3" style="font-size: 1.25rem; font-weight: 600;">Retornar</h5>
                            <a href="{{ route('welcome') }}" class="btn btn-primary px-4 py-2"
                                style="border-radius: 50px; font-size: 1rem;">
                                Volver a Welcome
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>