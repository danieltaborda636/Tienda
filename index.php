<?php
session_start(); // asegúrate de tener esto al inicio
include 'config/database.php';
include 'views/layouts/header.php';
include 'config/parametros.php';
?>
<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/inicio.css">

<div class="contenedor">
    <ul>
        <?php if (!isset($_SESSION['usuario'])): ?>
            <!-- Mostrar botones solo si NO ha iniciado sesión -->
            <li><a class="text" href="?view=login">Iniciar sesión</a></li>
            <li><a class="text" href="?view=register">Registrarse</a></li>
        
        <?php elseif (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
            <li><p class="text">Bienvenido,<a class="tex"> <?= $_SESSION['usuario']['nombre']; ?></a></p></li>
            <li><a class="text" href="#">Ver carrito</a></li>
            <li><a class="text" href="#">Mis pedidos</a></li>
            <li><a class="text" href="#">Gestionar Pedidos</a></li>
            <li><a class="text" href="#">Mis pedidos</a></li>
            <li><a class="text" href="?view=categoria">Crear categoría</a></li>
            <li><a class="text" href="controllers/logout.php">Cerrar sesión</a></li>
        
        <?php else:?>
            <li><p class="text">Bienvenido,<a class="tex"> <?= $_SESSION['usuario']['nombre']; ?></a></p></li>
            <li><a class="text" href="#">Mis pedidos</a></li>
            <li><a class="text" href="#">Ver carrito</a></li>
            <li><a class="text" href="controllers/logout.php">Cerrar sesión</a></li>
        <?php endif; ?>
        
    </ul>

    <?php
   if (isset($_GET['view'])) {
    $vista = $_GET['view'];

    if (isset($_SESSION['usuario']) && ($vista === 'login' || $vista === 'register')) {
        echo "<p>Ya estás logueado.</p>";
    } else {
        if ($vista === "register") {
            include 'views/user/register.php';
        } elseif ($vista === "login") {
            include 'views/user/login.php';
        } elseif ($vista === "categoria") {
            include 'views/user/categoria.php'; // ← esta es la parte que faltaba
        }
    }
}

    ?>
</div>

<div class="granContenedor">
    <?php
require_once 'models/product.php';
$product = new Product();
$productos = $product->obtenerTodos();
?>

<div class="product-grid">
    <?php while ($prod = $productos->fetch_assoc()): ?>
        <div class="product-card">
            <img src="assets/img/<?= $prod['imagen'] ?>" alt="<?= $prod['nombre'] ?>">
            <h3><?= $prod['nombre'] ?></h3>
            <p>$<?= number_format($prod['precio'], 0, ',', '.') ?></p>
            <a href="producto.php?id=<?= $prod['id'] ?>" class="btn">Comprar</a>
        </div>
    <?php endwhile; ?>
</div>

</div>

<?php include 'views/layouts/footer.php'; ?>
