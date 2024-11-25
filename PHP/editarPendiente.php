<?php
include 'conexion.php';


// Verificar si se recibió el ID del producto
if (!isset($_GET['id'])) {
    echo "ID del producto no proporcionado.";
    exit();
}

$id = intval($_GET['id']);

// Obtener la información actual del producto
$sql = "SELECT * FROM pendientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Producto no encontrado.";
    exit();
}

$producto = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM/qfQ4U92zF7WgLQ4lq0+sbj7t6Z46hmtcK8X" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/Menuestilo.css">
    <link rel="stylesheet" href="../CSS/Nvo_pendStyle.css">
    <title>AlmacenPro</title>
</head>
<body>
    <!-- header -->
<header>
  <!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark text-light">
<div class="container-fluid">
<!-- Logo -->
<a class="navbar-brand" href="#">AlmacenPro</a>

<!-- Botón para colapsar menú en dispositivos pequeños -->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<!-- Enlaces del menú -->
<div class="collapse navbar-collapse" id="navbarNav">
  <ul class="navbar-nav ms-auto">
    
  </ul>
</div>
</div>
</nav>
</header>
    <!--Menu Desplegable-->
<div id="sidebar">
<div class="toggle-btn">
  <span>&#9776;</span>
</div>
<ul>
  <li>
      <img src="../IMG/icons/usuario.png" width="50%" height="50%">
  </li>
  <li class="list_item">
      <div class="list_button">
          <a href="verInv.php" class="nav_link nav_link--inside" text-align="center" >Ver Inventario</a>
      </div>
      
      <div class="list_button">
          <a href="../Nvo_prod.html" class="nav_link nav_link--inside">Añadir Producto</a>
      </div>
      
      <div class="list_button">
          <a href="../prod_pendiente.php" class="nav_link nav_link--inside" >Producto Pendiente</a>
      </div>
      <br>
      <div class="list_button">
          <a href="logout.php" class="nav_link nav_link--inside " >Cerrar Sesion</a>
      </div>
  </li>
</ul>
</div>
    <div class="container mt-5 containerLogin">
        <h2 class="mb-4 text-center">Editar Producto Pendiente</h2>
        <form action="actualizarPendiente.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="imagenUrl" class="form-label">URL de la Imagen</label>
                <input type="text" class="form-control" id="imagenUrl" name="imagenUrl" value="<?php echo $producto['imagenUrl']; ?>" required>
            </div>
            <center>
                <img id="preview" src="IMG/icons/placeholder-1.png" height="200" width="200" alt="Vista previa de la imagen">
            </center>
            <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
        </form>
    </div>
</body>
<script src="../JS/scripts.js"></script>
<script src="../JS/Menu.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
