<?php
include 'conexion.php';

// Verificar que se haya recibido el ID del producto y el precio unitario
if (isset($_POST['id']) && isset($_POST['precioUnitario'])) {
    $id = intval($_POST['id']);
    $precioUnitario = floatval($_POST['precioUnitario']);

    // Obtener el producto pendiente desde la base de datos
    $sql = "SELECT * FROM pendientes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        // Insertar el producto en la tabla de productos
        $insertSql = "INSERT INTO productos (usuario_id, nombre, imagenUrl, cantidad, preciouni) 
                      VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("isssd", 
            $producto['usuario_id'], 
            $producto['nombre'], 
            $producto['imagenUrl'], 
            $producto['cantidad'], 
            $precioUnitario
        );
        if ($insertStmt->execute()) {
            // Eliminar el producto de la tabla de pendientes después de agregarlo a productos
            $deleteSql = "DELETE FROM pendientes WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $id);
            $deleteStmt->execute();

            echo "<script>
            alert('Producto actualizado correctamente.');
            window.location.href = 'verInv.php';
                </script>";
        } else {
            echo "Error al mover el producto a la tabla de productos.";
        }
    } else {
        echo "Producto pendiente no encontrado.";
    }

    $stmt->close();
} else {
    echo "ID de producto o precio unitario no proporcionado.";
}
?>
