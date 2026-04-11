@extends('layouts.app')

@section('content')

<br><br><br><br><br><br><br>

<div class="container">
    <h2>Crear cuenta</h2>
    <p>La contraseña debe contener al menos 6 caracteres</p>

    <form method="POST" action="/registro" id="registerForm">
        @csrf

        <input type="email" name="usuario" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" minlength="6" maxlength="20" required>

        <button type="submit">Crear cuenta</button>
    </form>

    <br>

    <a href="/login">
        <button type="button">Volver al inicio</button>
    </a>

</div>

@endsection