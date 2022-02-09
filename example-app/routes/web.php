<?php

use App\Http\Controllers\CartaMagicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Creamos peticion GET http a url, a dos metodos del controlador index y create.

Route::get('/carta_magics', [CartaMagicController::class, 'index'])->name('carta_magics.index');
// ->middleware('auth'); para que necesitemos LOGIN antes de entrar a ruta
Route::get('/carta_magics/create', [CartaMagicController::class, 'create'])->name('carta_magics.create')->middleware('auth');
Route::post('/carta_magics', [CartaMagicController::class, 'store'])->name('carta_magics.store');

// Guiandonos en la tabla manejadores de controladores   https://laravel.com/docs/8.x/controllers

// aqui presentamos formulario
Route::get('/carta_magics/{carta_magic}/edit', [CartaMagicController::class, 'edit'])->name('carta_magics.edit');

// aqui al update del controller para validar antes del cambio
Route::put('/carta_magics/{carta_magic}', [CartaMagicController::class, 'update'])->name('carta_magics.update');