<?php
session_start();

// ============ ENRUTADOR MVC PARA controller & action ============
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];

    $nombreClase = 'Controlador' . ucfirst($controller);
    $rutaControlador = 'controllers/' . $nombreClase . '.php';

    if (file_exists($rutaControlador)) {
        require_once $rutaControlador;
        $controlador = new $nombreClase();

        if (method_exists($controlador, $action)) {
            call_user_func([$controlador, $action]);
            exit;
        } else {
            die("❌ La acción '$action' no existe en el controlador '$nombreClase'.");
        }
    } else {
        die("❌ El controlador '$nombreClase' no existe.");
    }
}
// ===============================================================

include 'config/database.php';
include 'views/layouts/header.php';
include 'config/parametros.php';
?>

<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/inicio.css">

<div class="contenedor">
    <ul>
        <?php if (!isset($_SESSION['usuario'])): ?>
            <li><a class="text" href="?view=login">Iniciar sesión</a></li><br>
            <li><a class="text" href="?view=register">Registrarse</a></li>

        <?php elseif ($_SESSION['usuario']['rol'] === 'admin'): ?>
            <li><p class="text">Bienvenido, <a class="tex"><?= $_SESSION['usuario']['nombre']; ?></a></p></li>
            <li><a class="text" href="./visualizacion.php">Ver carrito</a></li>
            <li><a class="text" href="#">Mis pedidos</a></li>
            <li><a class="text" href="#">Gestionar Pedidos</a></li>
            <li><a class="text" href="./visualizacion.php">Crear producto</a></li>
            <li><a class="text" href="?view=categoria">Crear categoría</a></li>
            <li><a class="text" href="controllers/logout.php">Cerrar sesión</a></li>

        <?php else: ?>
            <li><p class="text">Bienvenido, <a class="tex"><?= $_SESSION['usuario']['nombre']; ?></a></p></li>
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
                include 'views/user/categoria.php';
            }
        }
    }
    ?>
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
