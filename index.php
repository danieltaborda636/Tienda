<div class="contenedorTodo">
<?php
session_start();
include 'views/layouts/header.php';
include 'config/parametros.php';
?>
<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/inicio.css">

<div class="contenedor">
    <ul>
        <?php if (!isset($_SESSION['usuario'])): ?>
            <li><a class="text" href="views/user/login.php">Iniciar sesión</a></li><br>
            <li><a class="text" href="views/user/registro.php">Registrarse</a></li><br>


        <?php elseif ($_SESSION['usuario']['rol'] === 'admin'): ?>
            <li><p class="text">Bienvenido, <a class="tex"><?= $_SESSION['usuario']['nombre']; ?></a></p></li>
            <li><a class="text" href="./carrito.php">Ver carrito</a></li><br>
            <li><a class="text" href="#">Mis pedidos</a></li><br>
            <li><a class="text" href="#">Gestionar Pedidos</a></li><br>
            <li><a class="text" href="./crear_producto.php">Crear producto</a></li><br>
            <li><a class="text" href="views/user/categoria.php">Crear categoría</a></li><br>
            <li><a class="text" href="controllers/logout.php">Cerrar sesión</a></li>

        <?php else: ?>
            <li><p class="text">Bienvenido, <a class="tex"><?= $_SESSION['usuario']['nombre']; ?></a></p></li>
            <li><a class="text" href="#">Mis pedidos</a></li>
            <li><a class="text" href="#">Ver carrito</a></li>
            <li><a class="text" href="controllers/logout.php">Cerrar sesión</a></li>
        <?php endif; ?>
    </ul>

   
</div>

<div class="granContenedor">
    <?php
    if (isset($_GET['view']) && $_GET['view'] === "producto" && isset($_GET['id'])) {
        include 'views/user/producto.php';
    } else {
        require_once 'models/product.php';
        $product = new Product();
        $productos = $product->obtenerTodos();
    ?>
        <div class="product-grid">
            <?php while ($prod = $productos->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="archivos-subidos/productos/<?= $prod['imagen'] ?>" alt="<?= $prod['nombre'] ?>">
                    <h3><?= $prod['nombre'] ?></h3>
                    <p>$<?= number_format($prod['precio'], 0, ',', '.') ?></p>
                    <a href="/tienda_motos/Tienda/?view=producto&id=<?= $prod['id'] ?>" class="btn">Comprar</a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php } ?>
</div>

<?php include 'views/layouts/footer.php'; ?>

</div>
