<?php
session_start();
include 'conexion.php';

if (isset($_GET['error'])) {
    $error = $_GET['error'];
} else {
    $error = '';
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Validar que no estén vacíos
    if (empty($correo) || empty($password)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: ../login.html");
        exit();
    }

    // Preparar la consulta para buscar al usuario
    $sql = "SELECT id, nombre, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Si la preparación de la consulta falla, muestra el error
        die("Error en la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($password, $usuario['password'])) {
            // Iniciar sesión correctamente
            unset($_SESSION['error']); 
            $_SESSION['usuario_id'] = $usuario['id']; // Ajuste aquí
            $_SESSION['nombre'] = $usuario['nombre'];
            
            // Redirigir al dashboard
            header("Location: verInv.php");
            exit();
        } else {
            // Contraseña incorrecta
            $_SESSION['error'] = "Contraseña incorrecta.";
            header("Location: ../login.html");
            exit();
        }
        
    } else {
        // En caso de error, redirigir con el error como parámetro en la URL
            $_SESSION['error'] = "El correo electrónico no está registrado.";
            header("Location: ../login.html?error=1");
            exit();

    }

    $stmt->close();
    $conn->close();
}
?>
