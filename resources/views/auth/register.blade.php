<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Checkbox para aceptar términos -->
        <div class="mt-4">
            <label for="terms" class="inline-flex items-center">
                <input id="terms" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                    Acepto
                    <a href="#" id="show-privacy" class="underline text-indigo-600 hover:text-indigo-900">términos y
                        condiciones</a>
                </span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Ya estas registrado?') }}
            </a>

            <x-primary-button id="register-button" class="ms-4 btn-register" disabled>
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>

    <div id="privacy-modal"
        class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4 overflow-y-auto hidden"
        aria-modal="true" role="dialog" aria-labelledby="modal-title" aria-describedby="modal-description">

        <div
            class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-xl shadow-2xl max-w-3xl w-full max-h-[80vh] overflow-y-auto p-6 relative border border-gray-200 dark:border-gray-700">
            <!-- Botón de cerrar -->
            <button id="close-modal" aria-label="Cerrar aviso de privacidad"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-800 dark:hover:text-white text-3xl font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded">
                &times;
            </button>

            <!-- Título -->
            <h2 id="modal-title" class="text-3xl font-extrabold mb-6 text-center text-indigo-600 dark:text-indigo-400">
                Aviso de Privacidad
            </h2>

            <!-- Contenido -->
            <div id="modal-description" class="text-sm leading-relaxed whitespace-pre-line pr-2 text-center">
                En Nombre de “ViuLaSalle”, nos comprometemos a proteger la privacidad de
                los datos personales de nuestros usuarios. Este Aviso de Privacidad detalla
                cómo recopilamos, utilizamos, almacenamos y protegemos tu información, en
                cumplimiento con las leyes aplicables en materia de protección de datos
                personales.
                Para garantizar el buen funcionamiento de nuestra plataforma y ofrecerte una
                experiencia optimizada, recopilamos los siguientes tipos de información: datos
                personales, como tu nombre, correo electrónico y material fotográfico.
                Utilizamos esta información con los siguientes fines: proveer servicios
                relacionados con la plataforma y mejorar tu experiencia de usuario; compartir
                proyectos, experiencias y actividades académicas en un entorno seguro;
                ayudar a otros usuarios a conocer opciones disponibles, como el Bachillerato o
                Ciclos Formativos, basándonos en tus vivencias y logros académicos; y
                personalizar las recomendaciones y el contenido de la plataforma según tus
                intereses.
                En “ViuLaSalle”, valoramos tu privacidad y no compartimos tu información
                personal con terceros, excepto en los siguientes casos: cuando sea necesario
                para cumplir con la legislación aplicable o un proceso legal; o bajo tu
                consentimiento explícito para compartir datos con terceros, como instituciones
                educativas o colaboradores del proyecto.
                Adoptamos medidas técnicas y organizativas para proteger tu información
                personal contra accesos no autorizados, pérdidas, usos indebidos o
                alteraciones. Usamos tecnologías de cifrado y almacenamiento seguro para
                garantizar la integridad de los datos.
                Como usuario, tienes derecho a acceder a tus datos personales para revisarlos;
                solicitar la corrección de información incorrecta o incompleta; pedir la
                eliminación de tus datos personales cuando ya no sean necesarios para los
                fines del proyecto; y oponerte al uso de tus datos para fines específicos. 
                Para ejercer tus derechos, contáctanos a través de eliteleaguecompeticiones@gmail.com.
                Nos reservamos el derecho de actualizar este Aviso de Privacidad en cualquier
                momento. Cualquier modificación será notificada a través de nuestra
                plataforma o por correo electrónico. Te recomendamos revisarlo
                periódicamente.
                Si tienes preguntas sobre este Aviso de Privacidad o necesitas más información,
                no dudes en contactarnos:
                Correo electrónico: eliteleaguecompeticiones@gmail.com
                Teléfono: 641991359
                Dirección: Ferrer i Busquets, 81 25230 Mollerussa, Lleida, ESP.
            </div>
        </div>
    </div>




    <Style>
        .btn-register {
            background-color: #ffc107;
            /* amarillo actual */
            color: black;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .btn-register:disabled {
            background-color: #ffecb3;
            /* amarillo más claro */
            cursor: not-allowed;
            color: rgba(0, 0, 0, 0.6);
            /* texto más tenue */
        }
    </Style>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const checkbox = document.getElementById("terms");
            const btnRegister = document.getElementById("register-button");

            checkbox.addEventListener("change", () => {
                btnRegister.disabled = !checkbox.checked;
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("privacy-modal");
            const showLink = document.getElementById("show-privacy");
            const closeBtn = document.getElementById("close-modal");

            showLink.addEventListener("click", (e) => {
                e.preventDefault();
                modal.classList.remove("hidden");
            });

            closeBtn.addEventListener("click", () => {
                modal.classList.add("hidden");
            });

            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.classList.add("hidden");
                }
            });
        });

    </script>

</x-guest-layout>