<footer>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <div class="contactanos">
        <div class="contactanos-texto">
            <h1>Contacta con nosotros</h1>
            <p>Nos gustaría saber de ti. Si tienes alguna pregunta o comentario, no dudes en ponerte en contacto con nosotros.</p>
        </div>
        <div class="redes">

        </div>
    </div>

    <div class="logo">
        <img src="../../img/la-salle-mollerussa.png" alt="Logo La Salle Mollerussa">
    </div>
    <div class="informacion">
        <div class="datos">
            <div>
                <h1><i class="fas fa-info-circle"></i> Contacto</h1>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Ferrer Busquets, 17 - 25230 Mollerussa, Lleida</li>
                    <li><i class="fas fa-phone"></i> 973 600 270</li>
                    <li><i class="fas fa-envelope"></i> lasallemollerussa@lasalle.cat</li>
                </ul>
            </div>
            <a href="https://qualitat.creaescola.com" class="dataobject"></a>
        </div>
        <div class="mapa">
            <iframe
                tittle="Colegio La Salle Mollerussa" 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2982.177880707791!2d0.8922258913168474!3d41.63028636755688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a6eadb0ad18831%3A0x1b5c60471a879bde!2sColegio%20La%20Salle!5e0!3m2!1ses!2ses!4v1746696852924!5m2!1ses!2ses" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
    <div class="detalles">
        © 2022 La Salle Mollerussa · Avís legal · Política de privadesa · Política de cookies · <i class="fas fa-laptop"></i> Creaescola.com
    </div>

    <style>
        .contactanos {
            width: 100%;
            height: 250px;
            background-color: #0053aa;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .redes {
            background-color: white;
            width: 500px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            border-radius: 20px 20px 0px 0px;
            border: 5px solid #ffc107;
            border-bottom: none;
        }
        .contactanos-texto {
            width: 100%;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .contactanos-texto h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .detalles {
            border-top: 1px solid #0053aa;
            width: 100%;
            text-align: center;
            color: #0053aa;

            font-size: 14px;
            font-weight: 300;
            padding: 25px 0;
        }
        @media (max-width: 1000px) {
            .detalles {
                font-size: 12px;
                padding: 20px 15px;
            }
        }

        .informacion {
            color: #0053aa;

            font-weight: 300;
            padding: 25px 20px 20px 20px;

            width: 100%;

            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .datos, .mapa {
            box-sizing: border-box;
        }
        .datos {
            font-size: 17px;
            padding: 0px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center; 
        }

        .mapa {
            border-radius: 15px;
            overflow: hidden;
            height: 200px;
        }

        @media (max-width: 1000px) {
            .informacion {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .datos, .mapa {
                width: 100%;
            }
            .datos{
                padding: 0px;
            }
        }

        .datos h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: left; 
        }
        .datos ul {
            list-style: none; 
            padding: 0;       
            margin: 0;
        }
        .datos li {
            display: flex;
            align-items: center;  
            gap: 8px;             
            margin-bottom: 8px;  
            text-align: left; 
        }
        .datos li i {
            min-width: 25px;      
            color: #ffc107;
        }

        .dataobject {
            content: "";
            background-image: url(https://qualitat.creaescola.com/content/svg/ce-QCW.png);
            width: 80px !important;
            height: 80px !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            background-position: center center !important;
            margin-left: 10px !important;
        }
        @media screen and (max-width: 1000px) {
            .dataobject {
                width: 80px !important;
                height: 66px !important;
            }
        }

        .logo {
            width: 100%;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
            margin-bottom: 10px;
        }
        .logo img {
            width: auto;
            height: 100%;
            object-fit: cover;
        }
    </style>
</footer>