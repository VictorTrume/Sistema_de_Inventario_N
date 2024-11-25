<?php
session_start(); 
include 'PHP/conexion.php'; // Incluir la conexión a la base de datos

if (!isset($_SESSION['usuario_id'])) {
  // Si no está logueado, redirigir al login
  echo "<script>
          alert('Debes iniciar sesión para registrar un Producto.');
          window.location.href = 'login.html';
      </script>";
  header("Location: login.html");
  exit();
}

// Obtener los productos pendientes para el usuario actual
$usuario_id = $_SESSION['usuario_id']; // Asegúrate de que el usuario esté autenticado

$sql = "SELECT * FROM pendientes WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM/qfQ4U92zF7WgLQ4lq0+sbj7t6Z46hmtcK8X" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/inventarioStyle.css">
    
    <link rel="stylesheet" href="CSS/Menuestilo.css">
    
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
<br>
<br>
 <!--Menu Desplegable-->
 <div id="sidebar">
    <div class="toggle-btn">
        <span>&#9776;</span>
    </div>
    <ul>
        <li>
            <img src="IMG/icons/usuario.png" width="50%" height="50%">
        </li>
        <li class="list_item">
            <div class="list_button">
                <a href="PHP/verInv.php" class="nav_link nav_link--inside" text-align="center" >Ver Inventario</a>
            </div>
            
            <div class="list_button">
                <a href="Nvo_prod.html" class="nav_link nav_link--inside">Añadir Producto</a>
            </div>
            
            <div class="list_button">
                <a href="prod_pendiente.php" class="nav_link nav_link--inside" >Producto Pendiente</a>
            </div>
            <br>
            <div class="list_button">
                <a href="PHP/logout.php" class="nav_link nav_link--inside " >Cerrar Sesion</a>
            </div>
        </li>
    </ul>
</div>


<!--Fin Menu Desplegable-->
  <!-- Contenedor principal -->
  <div class="container mt-5">
    <!-- Título centrado -->
     
    <h2 class="text-center mb-4">Producto Pendiente</h2>
    
    <!-- Campo de búsqueda centrado 
    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Buscar..." aria-label="Buscar">
        </div>-->
    </div>
    <center><a class="btn btn-primary" href="prod_pendienteAnadir.html">Añadir Producto</a></center>
  <br><br>
   
 <!-- Mostrar Productos Registrados -->
 <div class="container">

 <div class="row">
  <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="col-md-4 mb-4 d-flex">
          <div class="card h-100 w-100">
              <!-- Imagen del producto -->
              <img src="<?php echo $row['imagenUrl']; ?>" class="card-img-top product-img" alt="<?php echo $row['nombre']; ?>">

              <!-- Información del producto -->
              <div class="card-body text-center">
                  <h5 class="card-title"><?php echo $row['nombre']; ?></h5>

                  <!-- Controles de cantidad -->
                  <div class="d-flex justify-content-center align-items-center mb-3">
                      <span>Cantidad: <?php echo $row['cantidad']; ?></span>
                  </div>

                  <!-- Botón para editar producto -->
                  <a href="PHP/editarPendiente.php?id=<?php echo $row['id']; ?>" class="btn btn-primary w-100 mb-2">Editar Producto</a>

                  <!-- Botón para eliminar producto -->
                  <button class="btn btn-danger w-100" onclick="eliminarProducto(<?php echo $row['id']; ?>)">Eliminar Producto</button>

                  <!-- Formulario para surtir el producto -->
                  <form method="POST" action="PHP/surtirPendiente.php">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>"> <!-- ID del producto pendiente -->
                      <div class="mb-3">
                          <label for="precioUnitario" class="form-label">Precio Unitario</label>
                          <input type="number" step="0.01" class="form-control" id="precioUnitario" name="precioUnitario" required>
                      </div>
                      <button type="submit" class="btn btn-success">Surtir Producto</button>
                  </form>
              </div>
          </div>
      </div>
  <?php } ?>
  </div>
</div>
</div>



  <!-- Footer -->
<footer class="text-center text-lg-start mt-5">
    <div class="container p-4">
      <div class="row">
        <div class="col-lg-4 col-md-12 mb-4">
          <h5 class="text-uppercase">Acerca de Nosotros</h5>
          <p>
            Almacen Pro es una solución integral para la gestión de inventarios, diseñada para facilitar y optimizar el control de tus productos.
          </p>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <!-- espacio para mantener divididos ambas secciones de info -->
          </div>
  
  
        <div class="col-lg-4 col-md-6 mb-4">
          <h5 class="text-uppercase">Contacto</h5>
          <p><i class="fas fa-home"></i> Ciudad Juarez, Mexico</p>
          <p><i class="fas fa-envelope"></i> info@almacenpro.com</p>
          <p><i class="fas fa-phone"></i> +52 000 0000</p>
        </div>
      </div>
    </div>
  
    <div class="text-center p-3 bg-dark text-white">
      © 2024 Almacen Pro. Todos los derechos reservados.
    </div>
  </footer>
     <script src="JS/scripts.js"></script>
  <script src="JS/Menu.js" charset="utf-8"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>