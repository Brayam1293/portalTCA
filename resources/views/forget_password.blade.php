@extends('layouts.app')

@section('content')

<br><br><br><br><br><br><br>
@if(!session('otp_verified'))
<form method="POST" action="/forgot-password" id="forgotForm">
    @csrf
    <input type="email" name="usuario" placeholder="Correo" required>
    <button type="submit">Enviar OTP</button>
</form>
@endif

@if(session('otp_verified'))
<form method="POST" action="/reset-password">
    @csrf
    <input type="password" name="password" placeholder="Nueva contraseña" minlength="6" maxlength="20" required>
    @error('password')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" minlength="6" maxlength="20" required>
    @error('password_confirmation')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <button type="submit">Cambiar contraseña</button>
</form>
@endif