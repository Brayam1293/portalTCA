<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/foro', function () {
    return view('foro.foro');
})->name('foro');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// otp
Route::get('/otp', function () {
    return view('otp');
});

Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

// reenviar codigo
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);

// olvide contraseña
Route::get('/forgot-password', [AuthController::class, 'showForgot']);
Route::post('/forgot-password', [AuthController::class, 'sendOtp']);

// Verificar otp para reset password
Route::post('/verify-otp-reset', [AuthController::class, 'verifyOtpReset']);

Route::post('/reset-password', [AuthController::class, 'resetPassword']);