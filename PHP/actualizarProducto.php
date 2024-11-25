<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $cantidad = intval($_POST['cantidad']);
    $preciouni = $_POST['preciouni'];
    $imagenUrl = $_POST['imagenUrl'];

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($cantidad) || empty($preciouni) || empty($imagenUrl)) {
        echo "Por favor, completa todos los campos.";
        exit();
    }

    // Actualizar producto en la base de datos
    $sql = "UPDATE productos SET nombre = ?, cantidad = ?, preciouni = ?, imagenUrl = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $nombre, $cantidad, $preciouni, $imagenUrl, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Producto actualizado correctamente.');
            window.location.href = 'verInv.php';
        </script>";
    } else {
        echo "<script>
        alert('Error al actualizar el producto: " . $stmt->error . "');
        window.history.back();
    </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
