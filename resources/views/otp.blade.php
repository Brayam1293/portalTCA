@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Verificación de seguridad</h2>
    <p>Se te enviara un codigo de verificacion por correo</p>

    <form id="otpForm" method="POST">
        @csrf

        <input type="hidden" name="email" id="emailHidden">
        <input type="number" name="otp" placeholder="Introducir codigo" required>
        <button type="submit">Validar</button>
        <div id="otpMessage"></div>

        <button type="button" id="resendOtpBtn">Reenviar código</button>
        <div id="resendMessage"></div>
    </form>
</div> 