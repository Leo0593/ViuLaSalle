<footer>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <div class="cookies">
        <div class="cookies-i">
            <i class="fas fa-cookie-bite"></i>
        </div>
        <div class="cookies-separetor">
            <div class="cookies-texto">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-cookie-bite"></i>
                    <h1>Cookies</h1>
                </div>
                <p>Utilizamos cookies para mejorar tu experiencia en nuestro sitio web. Al continuar navegando, aceptas nuestra política de cookies.</p>
            </div>
            <div class="cookies-btns">
                <button class="btn-cookies">Aceptar</button>
                <button class="btn-cookies">Rechazar</button>
                <button class="btn-cookies">Configurar</button>
            </div>
        </div>
    </div>

    <div class="contactanos">
        <div class="contactanos-texto">
            <div style="text-align: left;">
                <h1>Contacta con nosotros</h1>
                <p>Nos gustaría saber de ti. Si tienes alguna pregunta o comentario, no dudes en ponerte en contacto con nosotros.</p>
            </div>
            <div>
                <button class="btn-contactanos">
                    <i class="fas fa-paper-plane"></i>
                    Contactar
                </button>
            </div>
        </div>
        <div class="redes">
            <a href="https://www.facebook.com/lasallemollerussa" target="_blank">
                <div class="redes-circle">
                    <i class="fab fa-facebook-f"></i>
                </div>
            </a>
            <a href="https://www.instagram.com/lasallemollerussa/" target="_blank">
                <div class="redes-circle">
                    <i class="fab fa-instagram"></i>
                </div>
            </a>
            <a href="https://twitter.com/LaSalleMolleru" target="_blank">
                <div class="redes-circle">
                    <i class="fab fa-twitter"></i>
                </div>
            </a>

            <a href="https://www.youtube.com/@lasallemollerussa" target="_blank">
                <div class="redes-circle">
                    <i class="fab fa-youtube"></i>
                </div>
            </a>
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
        .cookies {
            width: 100%;
            background-color: #ffc107;
            color: white;
            display: flex;
            padding: 40px 70px;
            justify-content: space-between;
            gap: 20px;
            position: sticky;
            bottom: 0;
            left: 0;
        }
        .cookies-i {
            width: 167px;
            height: 167px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 20px;
        }
        .cookies-i i {
            font-size: 167px;
        }
        .cookies-texto {
            width: 100%;
            padding: 0px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            text-align: left;
        }
        .cookies-texto h1 {
            font-size: 45px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .cookies-texto p {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        .cookies-texto i {
            display: none;
        }

        .cookies-btns {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }
        .btn-cookies {
            width: 100%;
            background-color: #0053aa;
            color: white;
            border: none;
            padding: 10px;
            font-size: 15px;
            font-weight: 700;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-cookies:hover, .btn-cookies:focus {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background-color: white;
            color: #0053aa;
        }
        .cookies-separetor {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
        @media screen and (max-width: 1000px) {
            .cookies {
                padding: 20px 20px;
                gap: 10px;
            }
            .cookies-texto {
                width: 100%;
                padding: 0px;
            }
            .cookies-btns {
                width: 100%;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
            .cookies-separetor {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .cookies-texto h1 {
                font-size: 35px;
                margin-bottom: 5px;
            }
            .cookies-texto p {
                font-size: 15px;
            }
            
            .cookies-i {
                display: none;
            }
            .cookies-texto i {
                display: block;
                font-size: 35px;
                margin-bottom: 10px;
            }
        }

        .contactanos {
            width: 100%;
            background-color: #0053aa;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .redes {
            background-color: white;
            padding: 30px 70px 20px 70px;
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
            padding: 50px 90px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
        @media screen and (max-width: 1000px) {
            .redes {
                width: 350px;
                height: 100px;
            }
            .contactanos-texto {
                width: 100%;
                padding: 40px 20px;
            }
            .contactanos-texto p {
                font-size: 1rem !important;
            }
        }
        .redes a {
            text-decoration: none;
        }
        .redes-circle{
            color: white;
            background-color: #0053aa;

            width: 50px;
            height: 50px;

            font-size: 30px;
            text-decoration: none;

            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .redes-circle:hover, .redes-circle:focus {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background-color: #ffc107;
            color: #0053aa;
        }

        .contactanos-texto h1 {
            font-size: 35px;
            font-weight: 700;
            margin-bottom: 18px;
        }
        .contactanos-texto p {
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .btn-contactanos {
            background-color: white;
            color: #0053aa;
            border: none;
            padding: 25px 30px;
            font-size: 25px;
            font-weight: 700;
            border-radius: 35px;
            cursor: pointer;
            transition: all 0.3s ease;
            
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .btn-contactanos i {
            font-size: 40px;
        }
        .btn-contactanos:hover, .btn-contactanos:focus {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background-color: #ffc107;
            color: #0053aa;
        }
        @media screen and (max-width: 1000px) {
            .btn-contactanos {
                padding: 15px 20px;
                font-size: 16px;
                border-radius: 25px;
            }
            .btn-contactanos i {
                font-size: 30px;
            }
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
            height: 300px;
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