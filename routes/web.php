<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('users')->name('users.')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::patch('{id}', [UserController::class, 'update'])->name('update');
    Route::patch('{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggleStatus');
});

Route::prefix('eventos')->name('eventos.')->group(function () {
    Route::get('/', [EventoController::class, 'index'])->name('index');
    Route::get('/create', [EventoController::class, 'create'])->name('create');
    Route::post('/', [EventoController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EventoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EventoController::class, 'update'])->name('update');
    Route::delete('/{id}', [EventoController::class, 'destroy'])->name('destroy');
});

Route::prefix('publicaciones')->name('publicaciones.')->group(function () {
    Route::get('/', [PublicacionController::class, 'index'])->name('index');
    Route::get('/create', [PublicacionController::class, 'create'])->name('create');
    Route::post('/', [PublicacionController::class, 'store'])->name('store');
});

Route::prefix('categorias')->name('categorias.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/create', [CategoriaController::class, 'create'])->name('create');
    Route::post('/', [CategoriaController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CategoriaController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoriaController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
