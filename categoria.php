<?php
session_start();
require_once 'config/database.php';
include 'config/parametros.php';
include 'views/layouts/header.php';

$conexion = Database::connect();

// Mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validar ID de categoría
$categoria_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($categoria_id <= 0) {
    echo "<p style='color:red'>⚠️ Categoría no válida.</p>";
    include 'views/layouts/footer.php';
    exit;
}

// Obtener nombre de la categoría
$sql_categoria = "SELECT nombre FROM categorias WHERE id = $categoria_id";
$res_categoria = mysqli_query($conexion, $sql_categoria);

if (!$res_categoria || mysqli_num_rows($res_categoria) == 0) {
    echo "<p style='color:red'>⚠️ Categoría no encontrada.</p>";
    include 'views/layouts/footer.php';
    exit;
}

$categoria_nombre = mysqli_fetch_assoc($res_categoria)['nombre'];

// Obtener productos de esa categoría
$sql_productos = "SELECT * FROM productos WHERE categoria_id = $categoria_id";
$res_productos = mysqli_query($conexion, $sql_productos);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($categoria_nombre) ?> | VCJ Motos</title>
    <link rel="stylesheet" href="assets/css/filtro.css"> 
</head>
<body>
<div class="contenedores"> <!-- bajamos el contenido -->
    <h2>Productos en: <?= htmlspecialchars($categoria_nombre) ?></h2>

    <div class="productos-grid">
        
        <?php if ($res_productos && mysqli_num_rows($res_productos) > 0): ?>
            <?php while ($producto = mysqli_fetch_assoc($res_productos)): ?>
                <div class="product-card">
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="uploads/productos/<?= htmlspecialchars($producto['imagen']) ?>" 
                             alt="<?= htmlspecialchars($producto['nombre']) ?>" width="150">
                    <?php else: ?>
                        <div style="width:150px; height:150px; background:#ddd;">Sin imagen</div>
                    <?php endif; ?>
                    
                    
                    <h4><?= htmlspecialchars($producto['nombre']) ?></h4>
                    <p>$<?= number_format($producto['precio'], 0, ',', '.') ?></p>
<<<<<<< HEAD
                    <a href="./views/user/producto.php?id=<?= $producto['id'] ?>" class="btn">Comprar</a>

=======
                    
>>>>>>> aa3df3f8147fd6661c6bfcba4c05ec47cc0e7bbb
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

<?php include 'views/layouts/footer.php'; ?>
