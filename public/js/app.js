
// Espera a que cargue el login
document.addEventListener("DOMContentLoaded", () => {
    // Toma los datos ingresados en el login
    const formLogin = document.getElementById("loginForm");

    if (formLogin) {
        // Detecta cuando se preciona el boton "submit"
        formLogin.addEventListener("submit", async (e) => {
            //  previene que la pagina se recargue para enviar el fomrlario
            e.preventDefault();

            // Toma los datos del formlario (email, password)
            const datos = new FormData(formLogin);
            // Toma el elemento que contiene el mensaje y quita mensajes anteriores
            const mensaje = document.getElementById("loginMessage");
            mensaje.innerText = "";

            // Por default el valor es false
            let camposVacios = false;

            // Toma los datos que ingresa el usaurio y verifica si estan vacios
            for (let [, value] of datos.entries()) {
                if (value.trim() === "") {
                    camposVacios = true;
                    break;
                }
            }

            // Si los campos estan vacios manda el mesnaje de alerta
            if (camposVacios) {
                mensaje.innerText = "No debe haber campos vacios!";
                mensaje.classList.add("text-danger");
                // Detiene el proceso aqui
                return;
            }

            try {
                // Envia los datos al servidor
                const response = await fetch("/login", {
                    method: "POST",
                    // Token CSRF (Se supone que es importante con Laravel)
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    },
                    // Manda los datos del fomulario
                    body: datos
                });

                // Convierte la respuesta del servidor a JSON
                const json = await response.json();

                if (json.success) {
                    const email = formLogin.querySelector("[name='email']").value;
                    localStorage.setItem("email", email);
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
    // Obtiene el input oculto donde se guardará el email
    const emailHidden = document.getElementById("emailHidden");
    // Si existe, le asigna el email guardado
    if (emailHidden) {
        let email = localStorage.getItem("email");

        // Si no viene del login, usar el de sesión (Blade)
        if (!email) {
            email = emailHidden.value;
        }
        emailHidden.value = email;
    }
    
    // Obtiene el contrenido de la verificación OTP
    const otpForm = document.getElementById("otpForm");

    // Valida si existe en la página
    if (otpForm) {

        // Detecta cuando el usuario envía el código OTP
        otpForm.addEventListener("submit", async (e) => {
            console.log("Entro al otp");

            e.preventDefault();

            // Obtiene los datos del formulario
            const datos = new FormData(otpForm);
            // Elemento donde se muestran mensajes
            const mensaje = document.getElementById("otpMessage");

            let email = localStorage.getItem("email");

            // Si no hay email en localStorage, es flujo de recuperación
            if (!email) {
                email = document.getElementById("emailHidden")?.value || null;
            }

            if (email) {
                datos.append("email", email);
            }

            try {
                // Detectar si es flujo de recuperación
                const isResetFlow = window.location.pathname.includes("otp") && !localStorage.getItem("email");

                // Determinar endpoint
                const url = isResetFlow ? "/verify-otp-reset" : "/verify-otp";
                // Validar OTP
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    },
                    body: datos
                });

                // Convierte respuesta a JSON
                const json = await response.json();

                // Si el código es correcto
                if (json.success) {
                    const isResetFlow = !localStorage.getItem("email");

                    localStorage.removeItem("email");
                    if (isResetFlow) {
                        window.location.href = "/forgot-password";
                    } else {
                        window.location.href = "/dashboard";
                    }

                } else {
                    // En caso de error muestra el error
                    mensaje.innerText = json.message;
                }

            } catch (error) {
                mensaje.innerText = "Error al verificar código";
            }
        });
    }

    // Reenviar codigo
    // Recibe la respuesta del boton
    const resendBtn = document.getElementById("resendOtpBtn");
    // Verifica si existe en la página
    if (resendBtn) {
        resendBtn.addEventListener("click", async () => {

            // Muestra el estado del envío
            const mensaje = document.getElementById("resendMessage");
            mensaje.innerText = "Enviando...";

            let email = localStorage.getItem("email");

            // Si no hay email en localStorage, usar el hidden (recuperación)
            if (!email) {
                email = document.getElementById("emailHidden")?.value;
            }

            try {
                // Solicita al servidor generar y enviar nuevo OTP
                const response = await fetch("/resend-otp", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ email: email })
                });

                // Convierte respuesta a JSON
                const json = await response.json();

                // Si se envió correctamente
                if (json.success) {
                    mensaje.innerText = "Se volvio a enviar el codigo";

                    // Desactiva el botón por 30 segundos
                    resendBtn.disabled = true;
                    setTimeout(() => {
                        resendBtn.disabled = false;
                    }, 30000);

                } else {
                    mensaje.innerText = json.message;
                }

            } catch (error) {
                mensaje.innerText = "Error al reenviar código";
            }
        });
    }

});