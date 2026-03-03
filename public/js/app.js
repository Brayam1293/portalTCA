

// Espera a que cargue el login
document.addEventListener("DOMContentLoaded", () => {
    // Toma los datos ingresados en el login
    const formLogin = document.getElementById("loginForm");

    // Si esta vacio detiene el JS
    if (!formLogin) return;

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
                window.location.href = "/dashboard";
            } else {
                mensaje.innerText = json.message;
            }
            
        } catch (error) {
            mensaje.innerText = "Error de conexión con el servidor";
        }
    });
});