<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>
            alert('Debes iniciar sesión para registrar un Producto.');
            window.location.href = '../login.html';
        </script>";
    header("Location: ../login.html");
   
    exit();
}


// Obtener el ID del usuario logueado
$usuario_id = $_SESSION['usuario_id'];

// Obtener los datos del formulario
$nombreP = $_POST['nombreP'];
$cantidadP = $_POST['cantidadP'];
$imagenUrl = $_POST['imagenUrl'];


// Validar que los campos obligatorios no estén vacíos
if (empty($nombreP) || empty($cantidadP) || empty($imagenUrl)) {
    echo "Por favor, completa todos los campos obligatorios.";
    exit();
}

// Insertar el producto en la base de datos
$sql = "INSERT INTO pendientes (usuario_id, nombre, cantidad, imagenUrl)
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $usuario_id, $nombreP, $cantidadP, $imagenUrl);

if ($stmt->execute()) {
    echo "<script>
            alert('Producto pendiente actualizado correctamente.');
            window.location.href = '../prod_pendiente.php';
        </script>";
} else {
    echo "Error al registrar el Producto " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
