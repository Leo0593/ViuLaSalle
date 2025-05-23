<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Viu LaSalle</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-sans text-gray-900 antialiased">
        <div class="fondo-login min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            
            <div >
                <a href="/">
                    <img src="../../img/ViuSalle.png" alt="Viu LaSalle" class="w-auto" style="height: 100px;">
                </a>
            </div>

            @props(['class' => ''])
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>


<style>
    .fondo-login {
        background-image: linear-gradient(to right, rgba(2, 77, 223, 0.8), rgba(2, 77, 223, 0.8)), url('../../img/Fondo.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;

        width: 100%;
        height: 100vh;

        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>