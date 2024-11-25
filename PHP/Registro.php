<?php
session_start(); // Iniciar la sesión
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $email = $_POST['email'];
    $password = $_POST['password'];
   

    // Validaciones
    if (empty ($nombre) || empty($rol)||empty($email) || empty($password)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: ../Registro.html");
        exit();
    }

    $checkSql = "SELECT * FROM usuarios WHERE email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $_SESSION['error'] = "El correo ya está registrado.";
        header("Location: ../registro.html");
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre,rol, password, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $rol, $passwordHash, $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Usuario registrado exitosamente.";
        header("Location: ../login.html");
    } else {
        $_SESSION['error'] = "Error al registrar usuario: " . $stmt->error;
        header("Location: ../Registro.html");
    }

    $stmt->close();
    $conn->close();
}
?>
