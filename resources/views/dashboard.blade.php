<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('Usuarios') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('eventos.index')" :active="request()->routeIs('eventos.index')">
                    {{ __('Eventos') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('publicaciones.index')"
                    :active="request()->routeIs('publicaciones.index')">
                    {{ __('Publicaciones') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('categorias.index')"
                    :active="request()->routeIs('categorias.index')">
                    {{ __('Categorias') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('niveles.index')" :active="request()->routeIs('niveles.index')">
                    {{ __('Niveles Educativos') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('cursos.index')" :active="request()->routeIs('cursos.index')">
                    {{ __('Cursos') }}
                </x-responsive-nav-link>

            </div>
        </div>

    </div>
</x-app-layout>