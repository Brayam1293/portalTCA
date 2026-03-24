@extends('layouts.app')

@section('content')

<br><br><br><br><br><br><br>

<div class="container">
    <h2>Verificación de seguridad</h2>
    <p>Se te enviara un codigo de verificacion por correo</p>

    <form id="otpForm" method="POST" action="{{ session('reset_user_id') ? url('/verify-otp-reset') : url('/verify-otp') }}">
        @csrf

        <input type="hidden" name="email" id="emailHidden" value="{{ session('reset_email') }}">
        <input type="hidden" id="flow" value="{{ session('flow') }}">

        <input type="text" name="otp" placeholder="Introducir codigo" required>
        <button type="submit">Validar</button>
        <div id="otpMessage"></div>

        <button type="button" id="resendOtpBtn">Reenviar código</button>
        <div id="resendMessage"></div>
    </form>
</div> 