@extends('layouts.app')
@section('title', 'Login')
@section('content')


<div class="form-login">
    <div class="form-login-under">
        <br>
        <h1>Bienvenido de nuevo</h1>
        <p>Accede a tu cuenta para participar en el foro</p>

        <form action="">
            <div class="flexcolum">
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-envelope" viewBox="0 0 16 16">
                        <path
                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                    </svg>
                    <input class="input" type="email" name="correo" placeholder="Correo electrónico" required>
                </div>
            </div>

            <p></p>
            <div class="flexcolum">
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-lock" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                    </svg>
                    <input class="input" type="password" name="password" placeholder="Contraseña" required> 
                </div>
            </div>

            <br></br>
            <a href="#!" class="left-txt">¿Olvidaste tu contraseña?</a>
            <br></br>
            <button class="button-blue">
                <!-- <div class="svg-wrapper"> -->
                     <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-lock" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                    </svg>
<!-- 
                </div> -->
                        Iniciar sesión</span>
                </button>
                <br></br>
                <a href="#!">¿No tienes una cuenta?</a>
                <br></br>
                <button class="button-cc">Crear una cuenta nueva -></button>
            </form>
        </div>
    </div>
</body>