document.addEventListener("DOMContentLoaded", () => {
    // Menú hamburguesa
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");
    if (hamburger && navLinks) {
        hamburger.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });
    }

    // Categorías en foro
    const items = document.querySelectorAll(".categories");
    items.forEach((item) => {
        item.addEventListener("click", () => {
            document.querySelector(".categories.active")?.classList.remove("active");
            item.classList.add("active");
            console.log("Filtrando por:", item.dataset.category);
        });
    });

    // Botón de like foro
    const card = document.querySelector(".lucide-heart");
    card.addEventListener("click", () => {
        card.classList.toggle("liked");
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
                    headers: { 
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") 
                    },
                    body: datos
                });
                const json = await response.json();
                if (json.success) {
                    localStorage.setItem("email", formLogin.querySelector("[name='email']").value);
                    window.location.href = "/otp";
                } else {
                    mensaje.innerText = json.message;
                }
            } catch (error) {
                mensaje.innerText = "Error de conexión con el servidor";
            }
        });
    }

    // OTP
    const otpForm = document.getElementById("otpForm");
    if (otpForm) {
        otpForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const datos = new FormData(otpForm);
            const mensaje = document.getElementById("otpMessage");
            let email = localStorage.getItem("email") || document.getElementById("emailHidden")?.value || null;
            if (email) datos.append("email", email);

            try {
                const isResetFlow = window.location.pathname.includes("otp") && !localStorage.getItem("email");
                const url = isResetFlow ? "/verify-otp-reset" : "/verify-otp";
                const response = await fetch(url, {
                    method: "POST",
                    headers: { 
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") 
                    },
                    body: datos
                });
                const json = await response.json();

                if (json.success) {
                    localStorage.removeItem("email");
                    window.location.href = isResetFlow ? "/forgot-password" : "/dashboard";
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
            let email = localStorage.getItem("email") || document.getElementById("emailHidden")?.value;

            try {
                const response = await fetch("/resend-otp", {
                    method: "POST",
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
});