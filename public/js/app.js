document.addEventListener("DOMContentLoaded", () => {
    // Menú hamburguesa
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");
    if (hamburger && navLinks) {
        hamburger.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });
    }

    // Botón de like foro
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function () {
            let postId = this.getAttribute('data-id');

            this.classList.toggle("liked");

            fetch(`/foro/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById(`likes-${postId}`).innerText = data.total;
            });
        });
    });

    // CATEGORIAS PARA COMENTARIOS
    const modal = document.getElementById('newcommentform');
    const btn = document.querySelector('.newcomment');
    const closeElements = document.querySelectorAll('.close, #btnCancelar');

    if (modal && btn) {
        btn.onclick = () => {
            modal.style.display = 'flex';
        };

        closeElements.forEach(el => {
            el.onclick = () => {
                modal.style.display = 'none';
            };
        });

        window.onclick = (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        };
    }
        //NÚMEROS SOLO VÁLIDOS PARA INPUT OTP  
    const otps = document.querySelectorAll('.ipcdv');

    otps.forEach(input => {
    input.addEventListener('input', () => {
        input.value = input.value.replace(/\D/g, '').slice(0, 6);
    });
    });

    // Login
    const formLogin = document.getElementById("loginForm");
    if (formLogin) {
        formLogin.addEventListener("submit", async (e) => {
            e.preventDefault();
            const datos = new FormData(formLogin);
            const mensaje = document.getElementById("loginMessage");
            mensaje.innerText = "";

            let camposVacios = false;
            for (let [, value] of datos.entries()) {
                if (value.trim() === "") camposVacios = true;
            }

            if (camposVacios) {
                mensaje.innerText = "No debe haber campos vacios!";
                mensaje.classList.add("text-danger");
                return;
            }

            try {
                const response = await fetch("/login", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: datos
                });

                if (response.status === 429) {
                    if (mensaje) {
                        mensaje.innerText = "Demasiados intentos. Intenta de nuevo en 1 minuto.";
                        mensaje.classList.add("text-danger");
                    }
                    return;
                }
                
                const json = await response.json();
                if (json.success) {
                    localStorage.clear();

                    localStorage.setItem("email", formLogin.querySelector("[name='email']").value);
                    window.location.href="/otp";
                } else if(json.disabled){
                    alert("Tu cuenta está desactivada. Debes recuperarla.");
                    localStorage.clear();

                    localStorage.setItem("email", formLogin.querySelector("[name='email']").value);
                    localStorage.setItem("flow", "reset");
                    window.location.href = "/forgot-password";
                } else {
                    mensaje.innerText = json.message;
                }
            } catch (error) {
                mensaje.innerText = "Error de conexión con el servidor";
            }
        });
    }

    // Registro
    const formRegister = document.getElementById("registerForm");

    if (formRegister) {
        formRegister.addEventListener("submit", (e) => {
            e.preventDefault();

            const email = formRegister.querySelector("[name='usuario']").value;

            localStorage.clear();
            localStorage.setItem("email", email);
            localStorage.setItem("flow", "register");

            formRegister.submit();
        });
    }

    // OTP
    const otpForm = document.getElementById("otpForm");
    if (otpForm) {
        const flow = localStorage.getItem("flow") || "";

        otpForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const datos = new FormData(otpForm);
            const mensaje = document.getElementById("otpMessage");
            let email = localStorage.getItem("email");

            if (!email) {
                email = document.getElementById("emailHidden")?.value;
            }

            if (email) {
                datos.append("email", email);
            }
            

            try {
                let url = "/verify-otp";

                if (flow === "register") {
                    url = "/verify-otp-register";
                } else if (flow === "reset") {
                    url = "/verify-otp-reset";
                }
                const response = await fetch(url, {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: datos
                });

                if (response.status === 429) {
                    if (mensaje) {
                        mensaje.innerText = "Demasiados intentos. Espera un momento antes de intentar de nuevo.";
                    }
                    return;
                }

                const json = await response.json();

                if (json.success) {
                    localStorage.removeItem("email");
                    if (flow === "register") {
                        localStorage.removeItem("flow");
                        window.location.href = "/login";
                    } 
                    else if (flow === "reset") {
                        window.location.href = "/forgot-password";
                    } 
                    else {
                        localStorage.removeItem("flow");
                        window.location.href = "/foro";
                    }

                } else {
                    mensaje.innerText = json.message;
                }
            } catch (error) {
                mensaje.innerText = "Error al verificar código";
            }
        });
    }

    // Reenviar código OTP
    const resendBtn = document.getElementById("resendOtpBtn");
    if (resendBtn) {
        resendBtn.addEventListener("click", async () => {
            const mensaje = document.getElementById("resendMessage");
            mensaje.innerText = "Enviando...";
            let email = localStorage.getItem("email");

            if (!email) {
                email = document.getElementById("emailHidden")?.value;
            }

            try {
                let url = "/resend-otp";

                    if (localStorage.getItem("flow") === "register") {
                        url = "/resend-otp-register";
                    }

                    const response = await fetch(url, {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ email })
                });
                const json = await response.json();
                if (json.success) {
                    mensaje.innerText = "Se volvió a enviar el código";
                    resendBtn.disabled = true;
                    setTimeout(() => { resendBtn.disabled = false; }, 30000);
                } else {
                    mensaje.innerText = json.message;
                }
            } catch (error) {
                mensaje.innerText = "Error al reenviar código";
            }
        });
    }

    // Filtrado
    const categoriasFiltro = document.querySelectorAll(".categories");
    const temas = document.querySelectorAll(".cardcomment");
    const buscador = document.querySelector(".bi");

    if (categoriasFiltro.length && temas.length) {

        let categoriaActual = "todos";

        categoriasFiltro.forEach(cat => {
            cat.addEventListener("click", function () {

                categoriaActual = this.dataset.category;

                categoriasFiltro.forEach(c => c.classList.remove("active"));
                this.classList.add("active");

                filtrar();
            });
        });

        if (buscador) {
            buscador.addEventListener("input", filtrar);
        }

        function filtrar() {
            const texto = buscador.value.toLowerCase();
            const userId = document.body.dataset.userid;

            temas.forEach(tema => {

                const categoria = tema.dataset.category;
                const usuario = tema.dataset.user;
                const titulo = tema.dataset.title;
                const mensaje = tema.dataset.message;

                let mostrar = true;

                // Categorias
                if (categoriaActual !== "todos") {

                    if (categoriaActual === "mis-publicaciones") {
                        mostrar = usuario == userId;
                    } else {
                        mostrar = categoria === categoriaActual;
                    }
                }

                // Busqueda
                if (texto && !(titulo.includes(texto) || mensaje.includes(texto))) {
                    mostrar = false;
                }

                tema.style.display = mostrar ? "block" : "none";
            });
        }
    }

    // Mostrar comentarios
    document.querySelectorAll('.toggle-comments').forEach(btn => {
        btn.addEventListener('click', function () {

            let id = this.getAttribute('data-id');
            let box = document.getElementById(`comentarios-${id}`);

            if (box.style.display === "none") {
                box.style.display = "block";
            } else {
                box.style.display = "none";
            }

        });
    });

    // Eliminar temas (ocultar)
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {

            let postId = this.getAttribute('data-id');

            fetch(`/foro/${postId}/eliminar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.closest('.cardcomment').remove();
                }
            });
        });
    });

    // Boton de editar (Admin)
    window.editar = function(id)
    {
        document.getElementById('view' + id).style.display = 'none';
        document.getElementById('edit' + id).style.display = 'table-row';
    }

    // Boton de cancelar (Admin)
    window.cancelar = function(id)
    {
        document.getElementById('view' + id).style.display = 'table-row';
        document.getElementById('edit' + id).style.display = 'none';
    }

    // Crear user (Admin)
    window.crearUsuario = function()
    {
        let fila = document.getElementById('createRow');

        if(fila){
            fila.style.display = 'table-row';
        }
    }

    // Cancelar creacion de user (Admin)
    window.cancelarCrear = function()
    {
        let fila = document.getElementById('createRow');

        if(fila){
            fila.style.display = 'none';
        }
    }

    // Forgot Password
    const forgotForm = document.getElementById("forgotForm");

    if (forgotForm) {
        forgotForm.addEventListener("submit", () => {

            localStorage.removeItem("flow");
            localStorage.setItem("flow", "reset");

            const email = forgotForm.querySelector("[name='usuario']").value;
            localStorage.setItem("email", email);
        });
    }

    // Buscador (Admin)
    const buscadorAdmin = document.getElementById("buscarUsuario");

    if (buscadorAdmin) {
        buscadorAdmin.addEventListener("input", function () {

            let texto = this.value.toLowerCase();
            let filas = document.querySelectorAll(".fila-usuario");

            filas.forEach(fila => {
                let contenido = fila.innerText.toLowerCase();

                if (contenido.includes(texto)) {
                    fila.style.display = "";
                } else {
                    fila.style.display = "none";
                }
            });

        });
    }

    let resultadosBusqueda = [];
    let indiceBusqueda = -1;

    window.toggleBuscadorNavbar = function () {
        const input = document.getElementById("globalSearch");
        const up = document.getElementById("btnUpSearch");
        const down = document.getElementById("btnDownSearch");

        if (!input) return;

        if (input.style.display === "none" || input.style.display === "") {
            input.style.display = "inline-block";

            if (up) up.style.display = "inline-block";
            if (down) down.style.display = "inline-block";
            input.focus();
        } else {
            input.style.display = "none";

            if (up) up.style.display = "none";
            if (down) down.style.display = "none";

            input.value = "";
            limpiarMarcadosBusqueda();
        }
    };

    const buscadorGlobal = document.getElementById("globalSearch");

    if (buscadorGlobal) {

        buscadorGlobal.addEventListener("input", function () {
            ejecutarBusquedaGlobal(this.value.trim());
        });

        buscadorGlobal.addEventListener("keydown", function (e) {

            if (e.key === "ArrowDown") {
                e.preventDefault();
                moverBusqueda(1);
            }

            if (e.key === "ArrowUp") {
                e.preventDefault();
                moverBusqueda(-1);
            }
        });
    }

    function limpiarMarcadosBusqueda() {

        document.querySelectorAll(".resultado-busqueda").forEach(el => {
            el.classList.remove("resultado-busqueda");
        });

        document.querySelectorAll(".resultado-activo").forEach(el => {
            el.classList.remove("resultado-activo");
        });

        resultadosBusqueda = [];
        indiceBusqueda = -1;
    }

    function ejecutarBusquedaGlobal(texto) {

        limpiarMarcadosBusqueda();

        if (texto === "") return;

        let elementos = document.querySelectorAll(
            "body *:not(nav *):not(.fixed-top *):not(.nav-links *):not(.container_logo *)"
        );

        elementos.forEach(el => {

            if (el.children.length > 0) return;
            if (!el.innerText) return;

            let contenido = el.innerText.trim().toLowerCase();

            if (contenido.includes(texto.toLowerCase())) {
                el.classList.add("resultado-busqueda");
                resultadosBusqueda.push(el);
            }
        });

        if (resultadosBusqueda.length > 0) {
            indiceBusqueda = 0;
            enfocarResultado();
        }
    }

    function moverBusqueda(direccion) {

        if (resultadosBusqueda.length === 0) return;

        indiceBusqueda += direccion;

        if (indiceBusqueda >= resultadosBusqueda.length) {
            indiceBusqueda = 0;
        }

        if (indiceBusqueda < 0) {
            indiceBusqueda = resultadosBusqueda.length - 1;
        }

        enfocarResultado();
    }

    window.moverBusqueda = moverBusqueda;

    function enfocarResultado() {

        document.querySelectorAll(".resultado-activo").forEach(el => {
            el.classList.remove("resultado-activo");
        });

        const actual = resultadosBusqueda[indiceBusqueda];

        if (!actual) return;

        actual.classList.add("resultado-activo");

        actual.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });
    }
});