@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div style="display: flex; align-items: center; justify-content: center;">
        <div class="main">

            <div class="box-crear-publicacion">
                <div class="box-crear-publicacion-txt">
                    <div class="box-crear-publicacion-text-texto">
                        Escribe tu publicación
                    </div>
                    <div class="box-crear-publicacion-text-agregarimagen">
                        <img src="../../img/agregar.png" alt="">
                    </div>
                </div>
                <div class="box-crear-publicacion-botones">
                    <button class="btn-crear-publicacion">Publicar</button>
                </div>
            </div>

            <div class="box-publicacion">
                <div class="box-publicacion-header">
                    <div class="box-publicacion-header-user"></div>
                    User
                </div>

                <div class="box-publicacion-img" style="background-image: url('../../img/naavidad2.avif');"></div>

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
    </div>

</body>