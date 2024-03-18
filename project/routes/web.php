<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PersonagemController;
use App\Http\Controllers\QuadrinhoController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Home');
// });

Route::resource('personagem', PersonagemController::class);
Route::post('/personagem/{id}', [PersonagemController::class, 'update']);
Route::resource('quadrinho', QuadrinhoController::class);
Route::post('/quadrinho/{id}', [QuadrinhoController::class, 'update']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('registro');
Route::post('/registro', [AuthController::class, 'register']);



