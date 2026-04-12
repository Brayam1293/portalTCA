<nav class="fixed-top">
  <div class="container_logo">
    <a href="" class="logo">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#8DF1F8" stroke-width="2" stroke-linecap="round"   stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart">
        <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"/>
      </svg>
      Portal de la Información sobre el TCA
    </a>
  </div>

    <!-- Botón hamburguesa responsive -->
    <div class="hamburger">
    <span></span>
    <span></span>
    <span></span>
  </div>


  <ul class="nav-links">
    <li><a href="{{ request()->is('/') ? '#inicio' : route('home') }}" class="nav_link">Inicio</a></li>
    <li><a href="{{ request()->is('/') ? '#abouttca' : route('home') . '#abouttca' }}" class="nav_link">Sobre TCA</a></li>
    <li><a href="" class="nav_link fz">Test</a></li>
    <li><a href="{{ route('foro') }}" class="nav_link">Foro</a></li>
    <li><a href="{{ request()->is('/') ? '#tipos' : route('home') . '#tipos' }}" class="nav_link">Tipos</a></li>
        <li><a href="{{ request()->is('/') ? '#sintomas' : route('home') . '#sintomas' }}" class="nav_link">Síntomas</a></li>
    <li class="nav-search-box">
      <a class="search" href="javascript:void(0);" onclick="toggleBuscadorNavbar()">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6A7282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m21 21-4.34-4.34"/>
          <circle cx="11" cy="11" r="8"/>
        </svg>
      </a>

      <input type="text" id="globalSearch" placeholder="Buscar..." style="display:none;">
      <button id="btnUpSearch" style="display:none;" type="button" onclick="moverBusqueda(-1)">▲</button>
      <button id="btnDownSearch" style="display:none;" type="button" onclick="moverBusqueda(1)">▼</button>
    </li>
      @auth
      <form action="/logout" method="POST" style="display:inline;">
          @csrf
          <button type="submit">Cerrar sesión</button>
      </form>
      @endauth
    <li>
      @guest
        <a class="login" href="{{ route('login') }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6A7282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
          Entrar
        </a>
      @endguest

      @auth
        @if(auth()->user()->tipo_usuario == 1)
          <a class="login" href="/admin">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6A7282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            Admin
          </a>
        @endif
      @endauth
    </li>
    <li>
      <a class="help" href= "#">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#183133" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone">
          <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/>
        </svg>  
      Ayuda
      </a>
    </li>
  </ul>

</nav>
