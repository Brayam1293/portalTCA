@extends('layouts.app')
@section('content')
@section('title', 'Verificación')

<div class="otpctner">

    <div class="conotp">
        <form id="otpForm" method="POST" action="{{ session('reset_user_id') ? url('/verify-otp-reset') : url('/verify-otp') }}">
        @csrf

        <!-- icons -->
        <div class="ishield">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#183133" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-icon lucide-shield"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
        </div>
        
        <h2 class="title tforo">Verificación de Seguridad</h2>
        <p class="sttfr">Por seguridad, necesitamos verificar tu identidad. Ingresa el código de verificación que te enviamos por correo electrónico para completar tu registro.</p>

        <div class="continp">
            <div id="resendMessage" class="error-message"></div>
            <p class="txtnote cdv">Código de Verificación</p>

            <input type="hidden" id="emailHidden" name="email" value="{{ old('usuario') }}">
            <input type="hidden" id="flow" value="{{ session('flow') }}">

            <input type="text" inputmode="numeric" maxlength="6" pattern="[0-9]*" name="otp" placeholder="000000" class="ipcdv"requred>
            <div id="otpMessage" class="error-message"></div>
            <p class="txt-mini">Ingresa el código de 6 dígitos que recibiste</p>

        </div>
        <div class="notec">
            <div class="notecd1">
             <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#183133" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-icon lucide-shield"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>    
            </div>
            <div class="notecd2">
                <p class="txt-mini nt"><span class="note-bold">Nota:</span> Si no recibiste el código, revisa tu carpeta de spam o correo no deseado.</p>
            </div>                  
        </div>
        <button class="vcode" type="submit">Verificar Código</button>
        <p class="linkident" id="resendOtpBtn">¿No recibiste el código? Reenviar</p>

        </form>
    </div>
</div>