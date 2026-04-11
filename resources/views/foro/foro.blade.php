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
            @foreach($temas as $tema)
            @php
            $categorias = [
                1 => 'recuperacion',
                2 => 'familiares',
                3 => 'consejos',
                4 => 'positivismo'
            ];
            @endphp

            <div class="cardcomment"
                data-category="{{ $categorias[$tema->categoria] ?? 'otros' }}"
                data-user="{{ $tema->id_usuario }}"
                data-title="{{ strtolower($tema->titulo) }}"
                data-message="{{ strtolower($tema->mensaje) }}">
                <div class="ctnertop">
                    <div class="cc1"></div>

                    <div class="cc2">
                        <h2 class="txt-card-title">{{ $tema->titulo }}</h2>

                        <div class="uht">
                            <p class="txt-card-user usn">
                                {{ '@' . ($tema->user->usuario ?? 'Usuario') }}
                            </p>

                            <p class="txt-card-user hr">
                                {{ $tema->created_at->diffForHumans() }}
                            </p>

                            <p class="txt-card-user">.</p>

                            @php
                            $categoriasNombre = [
                                1 => 'Recuperación',
                                2 => 'Familiares',
                                3 => 'Consejos',
                                4 => 'Positivismo'
                            ];
                            @endphp

                            <p class="txt-card-user rn">
                                {{ $categoriasNombre[$tema->categoria] ?? 'General' }}
                            </p>
                        </div>
                    </div>
                </div>

                <p class="txt-card-cont">{{ $tema->mensaje }}</p>

                <hr>

                <div class="card-btm">
                    <div class="card-btm1 cb1 like-btn" data-id="{{ $tema->id_foro }}" style="cursor:pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-heart icons-foro">
                            <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"/>
                        </svg>

                        <p class="txt-card-mini nber" id="likes-{{ $tema->id_foro }}">
                            {{ $tema->likes->count() }}
                        </p>
                    </div>

                    <div class="card-btm1 cb2">
                        <p class="txt-card-mini cms toggle-comments" data-id="{{ $tema->id_foro }}" style="cursor:pointer;">
                            {{ isset($tema->comentarios) ? count($tema->comentarios) : 0 }} comentarios
                        </p>
                    </div>

                    @auth
                        @if(auth()->user()->tipo_usuario == 1 || auth()->user()->id == $tema->id_usuario)
                            <button class="delete-btn" data-id="{{ $tema->id_foro }}">
                                Eliminar
                            </button>
                        @endif
                    @endauth
                </div>

                <div class="comentarios-box" id="comentarios-{{ $tema->id_foro }}" style="display:none;">
                    <form action="{{ route('foro.comentar', $tema->id_foro) }}" method="POST">
                        @csrf
                        <input type="text" name="comentario" placeholder="Escribe un comentario..." required>
                        <button type="submit">Comentar</button>
                    </form>

                    @if(isset($tema->comentarios))
                        @foreach($tema->comentarios as $comentario)
                            <p>
                                <strong>{{ $comentario->usuario->usuario }}</strong>:
                                {{ $comentario->comentario }}
                            </p>
                        @endforeach
                    @endif
                </div>
            </div>
            @endforeach 
        </div>
    </div>