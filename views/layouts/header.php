<?php
if (!isset($_SESSION)) {
session_start(); // Iniciar sesión para manejar el estado del usuario
}
require_once __DIR__ . '/../../config/database.php';
// Crear conexión
$conexion = Database::connect(); // ✅ AQUI llamas al método y obtienes la conexión
?>
<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>VCJ MOTOS</title>
        <link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/header.css">
    </head>
    <body>
        <!-- CABECERA -->
        <header id="cabecera">
            <!-- LOGO -->
            <div class="logo">
                <a class="nombre" href="index.php">
                    VCJ MOTOS
                </a>
            </div>
            
            <!-- MENU -->
            <nav class="menu">
                <ul>
                    <li>
                        <a href="index.php">Inicio</a> <!-- Enlace a la página principal -->
                    </li>
                    <?php
                    $sql = "SELECT * FROM categorias ORDER BY nombre ASC"; // Consulta para obtener todas las categorías ordenadas alfabéticamente
                    $categorias = mysqli_query($conexion, $sql); // Ejecutar la consulta y guardar el resultado
                    // Verificar que la consulta devolvió resultados
                    if (!empty($categorias)):
                        while ($categoria = mysqli_fetch_assoc($categorias)): // Recorrer cada categoría obtenida
                    ?>
                            <li>
                                <!-- Enlace a la página que muestra entradas de esta categoría, pasando el id por URL -->
                                <a href="categoria.php?id=<?php echo $categoria['id']; ?>">
                                    <!-- Mostrar el nombre de la categoría, usando htmlspecialchars para seguridad -->
                                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                                </a>
                            </li>
                    <?php
                        endwhile; // Fin del ciclo while que recorre las categorías
                    endif; // Fin de la validación de que haya categorías
                    ?>
                </ul>
            </nav>
            
            <div class="clearfix"></div>
        </header>