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
        class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center pt-12 overflow-y-auto hidden">
        <div
            class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-xl shadow-2xl w-full max-w-3xl mx-4 p-6 relative border border-gray-200 dark:border-gray-700">

            <!-- Botón de cerrar -->
            <button id="close-modal"
                class="absolute top-3 right-4 text-gray-400 hover:text-gray-800 dark:hover:text-white text-2xl font-bold focus:outline-none">
                &times;
            </button>

            <!-- Título -->
            <h2 class="text-2xl font-bold mb-4 text-center text-indigo-600 dark:text-indigo-400">Aviso de Privacidad
            </h2>

            <!-- Contenido -->
            <div class="text-sm leading-relaxed whitespace-pre-line max-h-[70vh] overflow-y-auto pr-2">
                Aviso de Privacidad de ViuLaSalle

                En Nombre de “ViuLaSalle”, nos comprometemos a proteger la privacidad de los datos personales de
                nuestros usuarios. Este Aviso de Privacidad detalla cómo recopilamos, utilizamos, almacenamos y
                protegemos tu información, en cumplimiento con las leyes aplicables...

                [pega aquí todo el contenido completo]
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