<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\Welcome;
use App\Http\Controllers\NivelEducativoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\VerificacionController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ColeccionController;
use App\Http\Controllers\PublicacionColeccionController;
use App\Http\Controllers\InfoController;



Route::get('/', [welcome::class, 'index'])->name('welcome');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','role:ADMIN,PROFESOR' ])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('{id}', [UserController::class, 'update'])->name('update');
        Route::patch('{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggleStatus');
    });
});


Route::prefix('eventos')->name('eventos.')->group(function () {
    Route::get('/', [EventoController::class, 'index'])->name('index');
    Route::get('/todos', [EventoController::class, 'todoseventos'])->name('todos');
    Route::get('/create', [EventoController::class, 'create'])->name('create')->middleware('role:ADMIN,PROFESOR');
    Route::post('/', [EventoController::class, 'store'])->name('store')->middleware('role:ADMIN,PROFESOR');
    Route::get('/{id}/edit', [EventoController::class, 'edit'])->name('edit')->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}', [EventoController::class, 'update'])->name('update') ->middleware('role:ADMIN,PROFESOR');
    Route::delete('/{id}', [EventoController::class, 'destroy'])->name('destroy') ->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}/activate', [EventoController::class, 'activate'])->name('activate') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/{id}', [EventoController::class, 'show'])->name('show');
});



Route::prefix('categorias')->name('categorias.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/create', [CategoriaController::class, 'create'])->name('create') ->middleware('role:ADMIN,PROFESOR');
    Route::post('/', [CategoriaController::class, 'store'])->name('store') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/{id}/edit', [CategoriaController::class, 'edit'])->name('edit') ->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}', [CategoriaController::class, 'update'])->name('update') ->middleware('role:ADMIN,PROFESOR');
    Route::delete('/{id}', [CategoriaController::class, 'destroy'])->name('destroy') ->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}/activate', [CategoriaController::class, 'activate'])->name('activate') ->middleware('role:ADMIN,PROFESOR');
});


Route::prefix('niveles')->name('niveles.')->group(function () {
    Route::get('/', [NivelEducativoController::class, 'index'])->name('index');
    Route::get('/create', [NivelEducativoController::class, 'create'])->name('create') ->middleware('role:ADMIN,PROFESOR');
    Route::post('/', [NivelEducativoController::class, 'store'])->name('store') ->middleware('role:ADMIN,PROFESOR');
    Route::get('{id}/edit', [NivelEducativoController::class, 'edit'])->name('edit') ->middleware('role:ADMIN,PROFESOR');
    Route::put('{id}', [NivelEducativoController::class, 'update'])->name('update') ->middleware('role:ADMIN,PROFESOR');
    Route::delete('{id}', [NivelEducativoController::class, 'destroy'])->name('destroy') ->middleware('role:ADMIN,PROFESOR');
    Route::put('{id}/activate', [NivelEducativoController::class, 'activate'])->name('activate') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/show', [NivelEducativoController::class, 'show'])->name('show');
});

Route::prefix('cursos')->name('cursos.')->group(function () {
    Route::get('/', [CursoController::class, 'index'])->name('index');
    Route::get('/create', [CursoController::class, 'create'])->name('create') ->middleware('role:ADMIN,PROFESOR');
    Route::post('/', [CursoController::class, 'store'])->name('store') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit') ->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}', [CursoController::class, 'update'])->name('update') ->middleware('role:ADMIN,PROFESOR');
    Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy') ->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}/activate', [CursoController::class, 'activate'])->name('activate') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/{id}', [CursoController::class, 'show'])->name('show');
});

Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
    Route::get('/', [NotificacionController::class, 'index'])->name('index') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/create', [NotificacionController::class, 'create'])->name('create') ->middleware('role:ADMIN,PROFESOR');
    Route::post('/', [NotificacionController::class, 'store'])->name('store') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/{id}/edit', [NotificacionController::class, 'edit'])->name('edit') ->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}', [NotificacionController::class, 'update'])->name('update') ->middleware('role:ADMIN,PROFESOR');
    Route::delete('/{id}', [NotificacionController::class, 'destroy'])->name('destroy') ->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}/activate', [NotificacionController::class, 'activate'])->name('activate') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/{id}', [NotificacionController::class, 'show'])->name('show') ->middleware('role:ADMIN,PROFESOR');
});

Route::prefix('colecciones')->name('colecciones.')->group(function () {
    Route::get('/', [ColeccionController::class, 'index'])->name('index');
    Route::get('/create', [ColeccionController::class, 'create'])->name('create') ->middleware('role:ADMIN,PROFESOR');
    Route::post('/', [ColeccionController::class, 'store'])->name('store') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/{id}/edit', [ColeccionController::class, 'edit'])->name('edit') ->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}', [ColeccionController::class, 'update'])->name('update') ->middleware('role:ADMIN,PROFESOR');
    Route::delete('/{id}', [ColeccionController::class, 'destroy'])->name('destroy') ->middleware('role:ADMIN,PROFESOR');
    Route::put('/{id}/activate', [ColeccionController::class, 'activate'])->name('activate') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/{id}', [ColeccionController::class, 'show'])->name('show');
    Route::get('/misgrupos', [ColeccionController::class, 'misgrupos'])->name('misgrupos');
});

Route::prefix('publicacioncolecciones')->name('publicacioncolecciones.')->group(function () {
    Route::get('/', [PublicacionColeccionController::class, 'index'])->name('index');
    Route::get('/create', [PublicacionColeccionController::class, 'create'])->name('create');
    Route::post('/', [PublicacionColeccionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PublicacionColeccionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PublicacionColeccionController::class, 'update'])->name('update');
    Route::delete('/{id}', [PublicacionColeccionController::class, 'destroy'])->name('destroy');
    Route::put('/{id}/activar', [PublicacionColeccionController::class, 'activate'])->name('activate');
});

Route::prefix('publicaciones')->name('publicaciones.')->group(function () {
    Route::get('/', [PublicacionController::class, 'index'])->name('index') ->middleware('role:ADMIN,PROFESOR');
    Route::get('/create', [PublicacionController::class, 'create'])->name('create');
    Route::post('/', [PublicacionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PublicacionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PublicacionController::class, 'update'])->name('update');
    Route::delete('/{id}', [PublicacionController::class, 'destroy'])->name('destroy');
    Route::put('/{id}/activar', [PublicacionController::class, 'activate'])->name('activate');
    Route::post('/{id}/like', [PublicacionController::class, 'toggleLike'])->name('toggleLike');
    Route::post('/{id}/reportar', [PublicacionController::class, 'reportar'])->name('reportar');

});

Route::get('/publicacion/{id}/comentarios', [ComentarioController::class, 'verComentarios'])->name('comentarios.ver');
Route::post('/comentarios/store', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::put('comentarios/{id}/cambiar-estado', [ComentarioController::class, 'changeStatus'])->name('comentarios.changeStatus');

Route::get('/verificacion', [VerificacionController::class, 'index'])->name('verificacion.index');
Route::post('/verificacion', [VerificacionController::class, 'validar'])->name('verificacion.validar');

Route::get('/info', [InfoController::class, 'index'])->name('info.index');

require __DIR__ . '/auth.php';
