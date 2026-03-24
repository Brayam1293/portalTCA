@extends('layouts.app')

@section('content')

<br><br><br><br><br><br><br>

<div class="container">
    <h2>Crear cuenta</h2>

    <form method="POST" action="/registro">
        @csrf

        <input type="email" name="usuario" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Crear cuenta</button>
    </form>

    <br>

    <a href="/login">
        <button type="button">Volver al inicio</button>
    </a>

</div>

@endsection