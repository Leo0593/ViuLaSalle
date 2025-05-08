<?php
$cantDigitos = 10;
?>

<x-guest-layout>
        <h1 class="text-2xl font-semibold text-center text-gray-800 dark:text-white mb-6">
            Verificación en 2 pasos
        </h1>

        @if(session('error'))
            <div class="text-sm text-red-600 bg-red-100 rounded text-center">
                {{ session('error') }}
            </div>
        @endif

        <form id="code-form" action="{{ route('verificacion.validar') }}" method="POST" class="space-y-6">
            @csrf

            <label for="codigo" class="block text-gray-700 dark:text-gray-300 font-medium text-center mb-2">
                Ingresa el código de {{ $cantDigitos }}  dígitos:
            </label>

            <div class="flex justify-center gap-2">
                @for ($i = 0; $i < $cantDigitos; $i++)
                    <input 
                        type="text" 
                        name="codigo[]" 
                        maxlength="1" 
                        required 
                        class="text-center text-xs px-1 py-1 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-500 dark:bg-gray-900 dark:text-white"
                        style="width: 35px; height: 40px; font-size: 18px; padding; 5px !important;"
                        oninput="handleInput(this, {{ $i }})"
                        id="codigo-{{ $i }}"
                    >
                @endfor
            </div>

            <input type="hidden" name="codigo" id="codigo_completo">

            <x-primary-button class="w-full  justify-center text-center" style="background-color: #ffc107; color: black;" onclick="joinCode(event)">
                {{ __('Verificar') }}
            </x-primary-button>
        </form>
    </div>

    <script>
        var cantDigitos = {{ $cantDigitos }};

        function handleInput(el, index) {
            if (el.value.length === 1 && index < (cantDigitos - 1)) {
                document.getElementById('codigo-' + (index + 1)).focus();
            }
        }

        function joinCode(event) {
            const inputs = document.querySelectorAll('[name="codigo[]"]');
            let fullCode = '';
            inputs.forEach(input => {
                fullCode += input.value;
            });

            if (fullCode.length !== cantDigitos) {
                event.preventDefault();
                alert('Por favor ingresa los ' + cantDigitos + ' dígitos del código.');
                return;
            }

            document.getElementById('codigo_completo').value = fullCode;
        }
    </script>
</x-guest-layout>