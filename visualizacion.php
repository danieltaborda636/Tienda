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
include 'config/parametros.php';
include 'views/layouts/header.php';
?>

<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/inicio.css">
<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/style.css">

<div class="contenedor">
    <ul>
        <?php if (!isset($_SESSION['usuario'])): ?>
            <li><a class="text" href="?view=login">Iniciar sesión</a></li>
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

        // Si ya está logueado, no mostrar login/register
        if (isset($_SESSION['usuario']) && ($vista === 'login' || $vista === 'register')) {
            echo "<p>Ya estás logueado.</p>";
        } else {
            if ($vista === "register") {
                include 'views/user/register.php';
            } elseif ($vista === "login") {
                include 'views/user/login.php';
            } elseif ($vista === "categoria") {
                include 'views/user/categoria.php';
            } elseif ($vista === "producto" && isset($_GET['id'])) {
                include 'views/user/producto.php';
            }
        }
    }
    ?>
</div>

<div class="gran">
<?php if (isset($_GET['mensaje'])): ?>
    <div style="padding:10px; margin-bottom:15px; border-radius:5px;">
        <?php
            switch ($_GET['mensaje']) {
                case 'ok':
                    echo "<p style='color:green;'>Producto guardado correctamente.</p>";
                    break;
                case 'error_bd':
                    echo "<p style='color:red;'>Error al guardar el producto en la base de datos.</p>";
                    break;
                case 'fallo_subida':
                    echo "<p style='color:red;'>La imagen no se pudo subir.</p>";
                    break;
                case 'tipo_no_valido':
                    echo "<p style='color:red;'>El archivo subido no es una imagen válida (solo JPG, PNG o GIF).</p>";
                    break;
                case 'error_imagen':
                    echo "<p style='color:red;'>Hubo un problema al subir la imagen.</p>";
                    break;
                case 'faltan_campos':
                    echo "<p style='color:red;'>Todos los campos deben estar llenos.</p>";
                    break;
                default:
                    echo "<p style='color:orange;'>Ocurrió un error inesperado.</p>";
                    break;
            }
        ?>
    </div>
<?php endif; ?>

<?php
require_once __DIR__ . '/config/database.php'; 
$conexion = Database::connect();
$sql_categorias = "SELECT * FROM categorias";
$resultado_categorias = mysqli_query($conexion, $sql_categorias);
?>

<!-- Formulario de creación de producto -->
<div class="contenedorproducto">
    <h2>Crear nuevo producto</h2>
    <form action="?controller=productos&action=store" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre del producto:</label><br>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="descripcion_producto">Descripción:</label><br>
        <textarea id="descripcion_producto" name="descripcion_producto" rows="4" cols="50" required></textarea><br>

        <label for="precio">Precio:</label><br>
        <input type="number" id="precio" name="precio" step="0.01" min="0" required><br>

        <label for="stock">Stock:</label><br>
        <input type="number" id="stock" name="stock" min="0" required><br>
</div>

<div class="crearproducto">
        <label for="oferta">¿Está disponible?</label><br>
        <select id="oferta" name="oferta">
            <option value="SI">Sí</option>
            <option value="NO">No</option>
        </select><br>

        <label for="categoria_id">Categoría:</label><br>
        <select id="categoria_id" name="categoria_id" required>
            <option value="">Selecciona una categoría</option>
            <?php while ($cat = $resultado_categorias->fetch_assoc()) : ?>
                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nombre']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="img">Imagen del producto:</label><br>
        <input type="file" id="img" name="img" accept="image/*" required><br>

        <button type="submit">Guardar producto</button>
</div>
    </form>
</div>

<?php include 'views/layouts/footer.php'; ?>
