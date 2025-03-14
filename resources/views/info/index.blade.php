@include('layouts.head')

<body>
    @include('layouts.navheader')

    <div class="evento-banner">
        <div class="evento-banner"></div>

        <div class="evento-header">
            <nav class="nav">
                <a class="nav-link scale-btn" href="#banner">BANNER</a>
                <a class="nav-link scale-btn" href="#fecha">FECHA</a>
                <a class="nav-link scale-btn" href="#info">INFO</a>
                <a class="nav-link scale-btn" href="#posts">POSTS</a>
                <a class="nav-link scale-btn" href="#posts">FOTOS</a>
            </nav>
        </div>

        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px;">

            <div id="fecha" class="box-evento" data-aos="zoom-in" data-aos-duration="1200" style="scroll-margin-top: 110px;">
                <div class="eventos-title-container">
                    <h2 class="eventos-title">FECHA</h2>
                </div>
                
                <div class="evento-info" style="display: flex; align-items: center; padding: 20px;">
                    <!-- Contenedor para la fecha y hora -->
                    <div style="background-color: ; display: flex; flex-direction: column; align-items: center; margin-right: 20px;">
                        <div style="font-size: 20px;">Ene.</div>  <!-- Mes abreviado -->
                        <div style="font-size: 26px;">1</div>  <!-- Día -->
                    </div>
                            
                    <!-- Contenedor para el nombre del evento y lugar -->
                    <div>
                        <div style="font-size: 20px; font-weight: bold;">Navidad Solidaria</div>
                    </div>

                    <!-- Botón de "Entradas" -->
                    <div style="margin-left: auto;">
                        <a href="#entradas" class="btn-1" style="border: 2px solid #000; color: #000; padding: 10px 20px; text-decoration: none; display: inline-flex; align-items: center;">
                            <i class="fa-solid fa-cart-plus" style="margin-right: 8px"></i>
                            Entradas
                        </a>
                    </div>
                </div>
            </div>

            <div 
                    id="info"
                    data-aos="zoom-in" data-aos-duration="1200"
                    class="box-evento"
                    style="scroll-margin-top: 110px;">

                    <div class="eventos-title-container">
                        <h2 class="eventos-title">INFO</h2>
                    </div>

                    <div style="display: flex; padding: 20px; gap: 50px;">
                        <div style="width: 50%;"> 
                            <p>
                                Navidad Solidaria es una iniciativa que busca fomentar la generosidad y el espíritu de ayuda durante las fiestas navideñas. Se trata de realizar acciones solidarias, como donar ropa, juguetes, alimentos o tiempo a quienes más lo necesitan. Muchas organizaciones, empresas y grupos comunitarios organizan eventos benéficos, campañas de recolección y actividades para apoyar a personas en situación de vulnerabilidad.
                                El objetivo de una Navidad Solidaria es compartir más allá de los regalos materiales, promoviendo valores como la empatía, la unión y la gratitud. Puede incluir desde visitas a hospitales y hogares de ancianos hasta cenas comunitarias o apadrinamiento de niños en riesgo de exclusión social.
                                En esencia, se trata de recordar que el verdadero significado de la Navidad no está solo en la celebración, sino en hacer que todos puedan vivir estas fechas con alegría y esperanza.
                            </p>
                        </div>

                        <div style="width: 50%; border-radius: 10px;
                            background-image: url('../../img/naavidad2.avif'); 
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            ">
                        </div>
                    </div>
            </div>

            <div 
                    id="info"
                    data-aos="zoom-in" data-aos-duration="1200"
                    class="box-evento"
                    style="scroll-margin-top: 110px;">

                    <div class="eventos-title-container">
                        <h2 class="eventos-title">INFO</h2>
                    </div>

                    <div style="display: flex; padding: 20px; gap: 50px;">
                        <div style="width: 50%;"> 
                            <p>
                                Navidad Solidaria es una iniciativa que busca fomentar la generosidad y el espíritu de ayuda durante las fiestas navideñas. Se trata de realizar acciones solidarias, como donar ropa, juguetes, alimentos o tiempo a quienes más lo necesitan. Muchas organizaciones, empresas y grupos comunitarios organizan eventos benéficos, campañas de recolección y actividades para apoyar a personas en situación de vulnerabilidad.
                                El objetivo de una Navidad Solidaria es compartir más allá de los regalos materiales, promoviendo valores como la empatía, la unión y la gratitud. Puede incluir desde visitas a hospitales y hogares de ancianos hasta cenas comunitarias o apadrinamiento de niños en riesgo de exclusión social.
                                En esencia, se trata de recordar que el verdadero significado de la Navidad no está solo en la celebración, sino en hacer que todos puedan vivir estas fechas con alegría y esperanza.
                            </p>
                        </div>

                        <div style="width: 50%; border-radius: 10px;
                            background-image: url('../../img/naavidad2.avif'); 
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            ">
                        </div>
                    </div>
                </div>
        </div>

        
    </div>
</body>