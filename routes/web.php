<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Routing\Middleware\ThrottleRequests;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('ONLINE');
})->name('home');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Se agrega limite de intentos por minuto
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// otp
Route::get('/otp', function () {
    return view('code.otp');
});

Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('throttle:3,1');

// reenviar codigo
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);

// olvide contraseña
Route::get('/forgot-password', [AuthController::class, 'showForgot']);
Route::post('/forgot-password', [AuthController::class, 'sendOtp']);

// Verificar otp para reset password
Route::post('/verify-otp-reset', [AuthController::class, 'verifyOtpReset'])->middleware('throttle:3,1');

Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// registro
Route::get('/registro', [AuthController::class, 'showRegister']);
Route::post('/registro', [AuthController::class, 'register']);
Route::post('/verify-otp-register', [AuthController::class, 'verifyOtpRegister'])->middleware('throttle:3,1');
Route::post('/resend-otp-register', [AuthController::class, 'resendOtpRegister']);

// foro
Route::get('/foro', [ForoController::class, 'index'])
    ->middleware('auth')
    ->name('foro');

Route::post('/temas', [ForoController::class, 'store'])
    ->middleware('auth');

Route::post('/foro/{id}/like', [ForoController::class, 'like'])
    ->name('foro.like');

Route::post('/foro/{id}/comentario', [ForoController::class, 'comentar'])
    ->name('foro.comentar');

Route::post('/foro/{id}/eliminar', [ForoController::class, 'eliminar']);

// admin
Route::get('/admin', [AdminController::class, 'dashboard'])
->middleware('auth');

Route::post('/admin/update/{id}', [AdminController::class, 'update'])
->middleware('auth');

Route::post('/admin/delete/{id}', [AdminController::class, 'delete'])
->middleware('auth');

Route::get('/admin/user/{id}', [AdminController::class, 'view'])
->middleware('auth');

Route::post('/admin/create', [AdminController::class, 'createUser']);

// cerrar sesion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
