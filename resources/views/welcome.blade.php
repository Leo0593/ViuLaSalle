@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div style="display: flex; align-items: center; justify-content: center;">
        <div class="main">
            <div class="opciones">
                <div class="opciones-bar-separator">Home</div>
                <li class="opciones-bar-item">
                    <a class="opciones-bar-link" href="{{ route('welcome') }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="opciones-bar-item">
                    <a class="opciones-bar-link" href="{{ route('info.index') }}">
                        <i class="fa-solid fa-user"></i>
                        <span>Perfil</span>
                    </a>
                </li>
            </div>
            <div class="contenido">
                <a href="#" class="box-crear-publicacion" data-toggle="modal" data-target="#exampleModalCenter">
                    <div class="box-crear-publicacion-header">
                        <div class="box-crear-publicacion-header-foto">
                            <img src="../../img/user-icon.png" alt="Foto de perfil">
                        </div>
                        <div class="box-crear-publicacion-header-texto">
                            ¿Qué estás pensando?
                        </div>
                    </div>
                    <div class="box-crear-publicacion-footer">
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-camera"></i>
                            <span>Foto</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-video"></i>
                            <span>Video</span>
                        </div>
                        
                    </div>
                </a> 

                <div class="box-publicacion">
                    <div class="box-publicacion-header">
                        <div class="box-publicacion-header-user"></div>
                        User
                    </div>

                    <div class="box-publicacion-img" style="background-image: url('../../img/salle.jpeg');"></div>

                    <div class="box-publicacion-footer">
                        <i class="fa-regular fa-heart" style="font-size: 25px;"></i>
                        <i class="fa-solid fa-heart" style="font-size: 25px;"></i>
                        <i class="fa-regular fa-comments" style="font-size: 25px;"></i>
                        <div class="descripcion">
                            User: descripcion de la publicacion donde puede haber
                        </div>
                    </div>
                </div>

                <div class="box-publicacion">
                    <div class="box-publicacion-header">
                        <div class="box-publicacion-header-user"></div>
                        User
                    </div>

                    <div class="box-publicacion-img" style="background-image: url('../../img/navidad.webp');"></div>

                    <div class="box-publicacion-footer">
                        <i class="fa-regular fa-heart" style="font-size: 25px;"></i>
                        <i class="fa-regular fa-comments" style="font-size: 25px;"></i>
                    </div>
                </div>

                <div class="box-publicacion">
                    <div class="box-publicacion-header">
                        <div class="box-publicacion-header-user"></div>
                        User
                    </div>

                    <div class="box-publicacion-img" style="background-image: url('../../img/bp1.jpg');"></div>

                    <div class="box-publicacion-footer">
                        <i class="fa-solid fa-heart" style="font-size: 25px;"></i>
                        <i class="fa-regular fa-comments" style="font-size: 25px;"></i>
                    </div>
                </div>
            </div>
            <div class="perfil">
                <div class="perfil-box">
                    <div class="perfil-header">
                        <img src="../../img/Fondo.png" alt="Fondo de perfil">
                    </div>
                    <div class="perfil-foto">
                        <img src="../../img/user-icon.png" alt="Foto de perfil">
                    </div>
                    <div class="perfil-info">
                        <div class="center-text" style="margin-bottom: 10px;">
                            <h3>Nombre de Usuario</h3>
                        </div>
                        <p>Correo: usuario@email.com</p>
                        <p>Ubicación: Ciudad, País</p>
                    </div>
                </div>
            </div>
            
        </div> 
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-usuario">
                        <div class="modal-usuario-foto">
                            <img src="../../img/user-icon.png" alt="Foto de perfil">
                        </div>

                        <h5 class="modal-title" id="exampleModalLongTitle">Nombre del Usuario</h5>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <textarea class="form-control" id="publicacion-texto" rows="5" placeholder="Escribe tu publicación aquí..."></textarea>
                    
                    <div class="modal-archivos">
                        <div class="icono" id="icono-imagen">
                            <i class="fa-solid fa-image"></i> 
                        </div>
                        <div class="icono" id="icono-video">
                            <i class="fa-solid fa-video"></i> 
                        </div>
                    </div>

                    <input type="file" id="file-input" style="display: none;" accept="image/*, video/*">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-publicar">Publicar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>