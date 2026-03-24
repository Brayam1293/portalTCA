@extends('layouts.app')
@section('title', 'Foro')
@section('body-class', 'foro-body')
@section('content')



<div class="foroctner">
    <nav class="breadcrumbs">
        <a href="{{ route('home') }}">Inicio</a>
        <span>></span>
        <span class="txtforobc">Foro de Apoyo</span>
    </nav>
    <div class="texto-forocnter">
        <h1 class="title">Comunidad y Foro</h1>
        <p class="txtsubtitles">
            Un espacio seguro para compartir, leer y conectar con otros.
        </p>
    </div>
    <div class="ctnerforo">
        <div class="cnerforou1 c1">
            <div class="categoryn">
                <ul class="categories-ul">
                    <li>
                        <div class="btncoment">
                            <button class="newcomment">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-plus-icon lucide-circle-plus">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M8 12h8" />
                                    <path d="M12 8v8" />
                                </svg>
                                <p class="categories txt-white">Nuevo Tema</p>
                            </button>
                            <div class="newcommentform" id="newcommentform">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <h2 class="textp">Crear Nuevo Tema</h2>


                                    <!-- Formulario para ingresar comentarios -->
                                    <form method="POST" action="/temas" class="comentsform">
                                        @csrf <label for="title">Título del tema</label>
                                        <input type="text" name="title" id="title"
                                            placeholder="Ej: Necesito consejos sobre..." required>

                                        <label for="categoria-tema">Categoría</label>
                                        <select name="categoria" id="categoria-tema" required>
                                            <option value="" disabled selected>Selecciona...</option>
                                            <option value="1">Recuperación</option>
                                            <option value="2">Familiares</option>
                                            <option value="3">Consejos</option>
                                            <option value="4">Positivismo</option>
                                        </select>

                                        <label for="message">Tu mensaje</label>
                                        <textarea name="message" id="message" rows="4"
                                            placeholder="Escribe tu mensaje..." required></textarea>

                                        <div
                                            style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                                           <button type="button" class="btn-cancelar" id="btnCancelar">Cancelar</button>
                                            <button type="submit">Publicar Tema</button>
                                        </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="spam">
                        <div class="categories-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="#101828" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-funnel-icon lucide-funnel">
                                <path
                                    d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                            </svg>
                            <h2 class="txtsubtitles s3">Categorías</h2>
                        </div>
                    </li>
                    <li class="categories active" data-category="todos">Todos</li>
                    <li class="categories" data-category="mis-publicaciones">
                        Mis publicaciones
                    </li>
                    <li class="categories" data-category="recuperacion">Recuperación</li>
                    <li class="categories" data-category="familiares">Familiares</li>
                    <li class="categories" data-category="consejos">Consejos</li>
                    <li class="categories" data-category="positivismo">Positivismo</li>
                </ul>
            </div>
            <div class="normasf">
                <h2 class="txtsubtitles s4">Normas del Foro</h2>
                <ul class="normas">
                    <li class="txt-normas">Sé amable y respetuoso.</li>
                    <li class="txt-normas">No compartas cifras de peso o calorías (puede ser detonante).</li>
                    <li class="txt-normas">Respeta la privacidad de otros.</li>
                    <li class="txt-normas">Este no es un sitio de crisis médica.</li>
                </ul>
            </div>
        </div>
        <div class="cnerforou1 c2">
            <div class="buscador">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#99A1AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search-icon lucide-search">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
                <input type="text" class="bi" placeholder="Busca temas en el foro...">
            </div>
            <!-- Contenedor de los comentarios -->
            <div class="cardcomment">
                <div class="ctnertop">
                    <div class="cc1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none"
                            stroke="#99A1AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-square-user-round-icon lucide-square-user-round">
                            <path d="M18 21a6 6 0 0 0-12 0" />
                            <circle cx="12" cy="11" r="4" />
                            <rect width="18" height="18" x="3" y="3" rx="2" />
                        </svg>
                    </div>
                    <div class="cc2">
                        <h2 class="txt-card-title">Mi primera semana en recuperación: Miedos y esperanzas</h2>
                        <div class="uht">
                            <p class="txt-card-user usn">@Maria_88</p>
                            <p class="txt-card-user hr">hace 2 horas</p>
                            <p class="txt-card-user">.</p>
                            <p class="txt-card-user rn">Recuperación</p>
                        </div>
                    </div>
                </div>
                <p class="txt-card-cont">Hola a todos, acabo de empezar mi tratamiento esta semana. Tengo mucho miedo
                    pero también sé que es lo correcto...</p>
                <hr>
                <div class="card-btm">
                    <div class="card-btm1 cb1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-heart-icon lucide-heart icons-foro">
                            <path
                                d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                        </svg>
                        <p class="txt-card-mini nber">25</p>
                    </div>
                    <div class="card-btm1 cb2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-message-square-icon lucide-message-square icons-foro">
                            <path
                                d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z" />
                        </svg>
                        <p class="txt-card-mini cms">1 comentarios</p>

                    </div>

                </div>
            </div>
        </div>
    </div>