 //Preview de la imagen antes de insertar----------------------
 // Obtener los elementos del campo URL y la imagen
 const imagenUrlInput = document.getElementById('imagenUrl');
 const previewImg = document.getElementById('preview');

 // Escuchar el evento "input" en el campo de URL
 imagenUrlInput.addEventListener('input', () => {
     const url = imagenUrlInput.value;

     // Validar que sea una URL válida para una imagen
     if (url) {
         previewImg.src = url;
     } else {
         previewImg.src = 'IMG/icons/placeholder-1.png'; // Placeholder si no hay URL válida
     }
 });

//pop-up eliminar prod
 function eliminarProducto(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        window.location.href = `verInv.php?eliminar_id=${id}`;
    }
}

//ver contraseña
document.getElementById('togglePassword').addEventListener('click', function () {
    // Obtener el campo de la contraseña
    const passwordField = document.getElementById('password');
    
    // Cambiar el tipo del input entre 'password' y 'text'
    const type = passwordField.type === 'password' ? 'text' : 'password';
    passwordField.type = type;

    // Cambiar el ícono entre 'eye' y 'eye-slash'
    const icon = this.querySelector('i');
    if (type === 'password') {
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
});

