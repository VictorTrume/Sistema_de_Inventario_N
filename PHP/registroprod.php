<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para registrar un Producto.";
    exit();
}

// Obtener el ID del usuario logueado
$usuario_id = $_SESSION['usuario_id'];

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$preciouni = $_POST['preciouni'];
$imagenUrl = $_POST['imagenUrl'];


// Validar que los campos obligatorios no estén vacíos
if (empty($nombre) || empty($cantidad) || empty($preciouni)) {
    echo "Por favor, completa todos los campos obligatorios.";
    exit();
}

// Insertar el producto en la base de datos
$sql = "INSERT INTO productos (usuario_id, nombre, cantidad, preciouni, imagenUrl)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issds", $usuario_id, $nombre, $cantidad, $preciouni, $imagenUrl);

if ($stmt->execute()) {
    echo "<script>
            alert('Producto actualizado correctamente.');
            window.location.href = 'verInv.php';
        </script>";
} else {
    echo "Error al registrar el Producto " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
