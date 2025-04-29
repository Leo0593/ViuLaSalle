@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="perfil-body">
        <!-- Banner -->
        <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">    
            <div class="perfil-banner-container">
                <div class="perfil-banner">
                    <img src="../../img/Fondo.png" alt="Banner de perfil">
                </div>

                <!-- Imagen de perfil y nombre -->
                <div class="foto-perfil">
                    <div class="perfil-img">
                        <img src="../../img/user-icon.png" alt="Foto de perfil">
                    </div>
                </div>
            </div>

            <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
                <div class="info-perfil">
                    <h1 class="perfil-nombre">Nombre de Usuario</h1>
                    <p class="perfil-descripcion">Descripción del usuario</p>
                </div>
            </div>
            
        </div>
        
    </div>
</body>
