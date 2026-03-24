document.addEventListener("DOMContentLoaded", () => {
    // Menú hamburguesa
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");

    if (hamburger && navLinks) {
        hamburger.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });
    }

    // Categorias en foro
    const items = document.querySelectorAll(".categories");

    items.forEach((item) => {
        item.addEventListener("click", () => {
            // Quitar el active anterior
            document
                .querySelector(".categories.active")
                ?.classList.remove("active");

            // Agregar active al clicado
            item.classList.add("active");

            // Obtener categoría
            const category = item.dataset.category;
            console.log("Filtrando por:", category);
        });
    });

    // Boton de like foro
    const card = document.querySelector(".lucide-heart");

    card.addEventListener("click", () => {
    card.classList.toggle("liked");
    });

    // Login (tu código existente)
    const formLogin = document.getElementById("loginForm");
    if (!formLogin) return;

    formLogin.addEventListener("submit", async (e) => {
        e.preventDefault();
        const datos = new FormData(formLogin);
        const mensaje = document.getElementById("loginMessage");
        mensaje.innerText = "";

        let camposVacios = false;
        for (let [, value] of datos.entries()) {
            if (value.trim() === "") {
                camposVacios = true;
                break;
            }
        }
        if (camposVacios) {
            mensaje.innerText = "No debe haber campos vacios!";
            mensaje.classList.add("text-danger");
            return;
        }

        try {
            const response = await fetch("/login", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: datos,
            });
            const json = await response.json();
            if (json.success) {
                window.location.href = "/dashboard";
            } else {
                mensaje.innerText = json.message;
            }
        } catch (error) {
            mensaje.innerText = "Error de conexión con el servidor";
        }
    });
});