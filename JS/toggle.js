// Función para alternar la visibilidad de la contraseña
// Esperamos a que el documento esté completamente cargado
document.addEventListener("DOMContentLoaded", function() {
    // Obtenemos el botón de toggle y el campo de la contraseña
    const togglePassword = document.getElementById("togglePassword");
    const passwordField = document.getElementById("password");

    // Si el togglePassword y el passwordField existen en la página
    if (togglePassword && passwordField) {
        togglePassword.addEventListener("click", function() {
            // Comprobamos si el tipo de input es 'password' o 'text'
            const type = passwordField.type === "password" ? "text" : "password";
            passwordField.type = type;

            // Cambiar el icono (opcional)
            this.querySelector("i").classList.toggle("fa-eye-slash");
        });
    }
});
