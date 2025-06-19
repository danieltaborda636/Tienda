<?php
<<<<<<< HEAD
session_start(); // asegúrate de tener esto al inicio
=======

>>>>>>> 596488b8c0aed32976c3a4c338d844a1d51f11b0
include 'config/database.php';
include 'views/layouts/header.php';
include 'config/parametros.php';
?>
<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/inicio.css">

<div class="contenedor">
    <ul>
<<<<<<< HEAD
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
=======
        <li><a class="text" href="./views/user/login.php">iniciar sesion</a></li>
       
     <li><a href="?registro=1">Registrarse</a></li>
        <?php
        if (isset($_GET['registro'])) {
            include './views/user/register.php';
        }
        ?>
          
    </ul>

<?php
// Miramos si en la URL hay algo como ?controller=algo&action=otraCosa
if (isset($_GET['controller']) && isset($_GET['action'])) {
    // Guardamos el nombre del controlador y lo que queremos que haga (la acción)
    $nombreControlador = $_GET['controller'];
    $accion = $_GET['action'];

    // Buscamos el archivo del controlador según lo que vino en la URL
    $archivo = 'controllers/controlador-' . $nombreControlador . '.php';

    // Le ponemos Controlador al principio para formar el nombre de la clase
    $clase = 'Controlador' . ucfirst($nombreControlador); 

    // Si ese archivo sí existe en la carpeta, lo usamos
    if (file_exists($archivo)) {
        require_once $archivo;

        // Creamos un nuevo objeto del controlador (como prenderlo pa que funcione)
        $controlador = new $clase();

        // Revisamos si ese controlador tiene la funcion que pedimos (como create o store)
        if (method_exists($controlador, $accion)) {
            $controlador->$accion(); // Aquí ya hacemos que se ejecute esa funcion, como guardar o mostrar
        } else {
            echo "<p> Esa función '$accion' no existe en ese controlador.</p>";
        }
    } else {
        echo "<p> No encontramos ese controlador llamado '$archivo'.</p>";
    }
}
?>
>>>>>>> 596488b8c0aed32976c3a4c338d844a1d51f11b0

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
