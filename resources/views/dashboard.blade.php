
@include('layouts.head')



<div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800">Panel de Administración</h1>

        <div class="mt-4">
            <p class="text-gray-600">Bienvenido al panel de administración. Aquí puedes gestionar los usuarios, eventos,
                publicaciones, categorías, niveles educativos y cursos.</p>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">


        <ul>
            <li class="opciones-bar-item">
                <a href="{{ route('users.index') }}"
                    class="opciones-bar-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li class="opciones-bar-item">
                <a href="{{ route('eventos.index') }}"
                    class="opciones-bar-link {{ request()->routeIs('eventos.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Eventos</span>
                </a>
            </li>
            <li class="opciones-bar-item">
                <a href="{{ route('publicaciones.index') }}"
                    class="opciones-bar-link {{ request()->routeIs('publicaciones.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>Publicaciones</span>
                </a>
            </li>
            <li class="opciones-bar-item">
                <a href="{{ route('categorias.index') }}"
                    class="opciones-bar-link {{ request()->routeIs('categorias.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags"></i>
                    <span>Categorías</span>
                </a>
            </li>
            <li class="opciones-bar-item">
                <a href="{{ route('niveles.index') }}"
                    class="opciones-bar-link {{ request()->routeIs('niveles.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Niveles Educativos</span>
                </a>
            </li>
            <li class="opciones-bar-item">
                <a href="{{ route('cursos.index') }}"
                    class="opciones-bar-link {{ request()->routeIs('cursos.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Cursos</span>
                </a>
            </li>
            <li class="opciones-bar-item">
                <a href="{{ route('welcome') }}" class="opciones-bar-link">
                    <i class="fa-solid fa-door-open"></i>
                    <span>Retornar a Welcome</span>
                </a>
            </li>
        </ul>

    </div>

</div>

 <!--
 <x-app-layout>
</x-app-layout>
-->
