<?php
session_start();
include 'config/database.php';
include 'config/parametros.php';
include 'views/layouts/header.php';
?>

<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/inicio.css">
<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/style.css">

<div class="contenedor">
    <ul>
        <?php if (!isset($_SESSION['usuario'])): ?>
            <li><a class="text" href="?view=login">Iniciar sesión</a></li><br>
            <li><a class="text" href="?view=register">Registrarse</a></li>
        <?php elseif ($_SESSION['usuario']['rol'] === 'admin'): ?>
            <li><p class="text">Bienvenido, <a class="tex"><?= $_SESSION['usuario']['nombre']; ?></a></p></li>
            <a class="text" href="/carrito.php">🛒 Ver carrito</a>
            <li><a class="text" href="#">Mis pedidos</a></li><br>
            <li><a class="text" href="#">Gestionar Pedidos</a></li><br>
            <li><a class="text" href="./visualizacion.php">Crear producto</a></li><br>
            <li><a class="text" href="?view=categoria">Crear categoría</a></li><br>
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
<
<!-- Formulario de creación de producto -->
<div class="contenedorproducto">
<?php
$carrito = $_SESSION['carrito'] ?? [];
?>

<h2 class="carrito_titulo">🛒 Carrito de Compras</h2>

<?php if (empty($carrito)): ?>
    <p>Tu carrito está vacío.</p>
<?php else: ?>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acciones</th>
        </tr>
        <?php
        $total = 0;
        foreach ($carrito as $item):
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['nombre']) ?></td>
            <td><img src="/tienda_motos/Tienda/archivos-subidos/productos/<?= htmlspecialchars($item['imagen']) ?>" width="50"></td>
            <td>$<?= number_format($item['precio'], 0, ',', '.') ?></td>
            <td>
                <form action="/tienda_motos/Tienda/controllers/carritoController.php" method="post" class="form-cantidad">
                    <input type="hidden" name="actualizar" value="1">
                    <span class="cantidad-texto" id="cantidad-texto-<?= $item['id'] ?>"><?= $item['cantidad'] ?></span>
                    <input type="number" name="cantidades[<?= $item['id'] ?>]" value="<?= $item['cantidad'] ?>" min="1"
                           class="cantidad-input" id="cantidad-input-<?= $item['id'] ?>" style="display:none;">
                    <button type="button" onclick="activarEdicion(<?= $item['id'] ?>)">✏️</button>
                    <button type="submit" class="btn-guardar" id="guardar-btn-<?= $item['id'] ?>" style="display:none;">✅</button>
                </form>
            </td>
            <td>$<?= number_format($subtotal, 0, ',', '.') ?></td>
            <td>
                <a href="/tienda_motos/Tienda/controllers/carritoController.php?eliminar=<?= $item['id'] ?>">❌</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" align="right"><strong>Total:</strong></td>
            <td><strong>$<?= number_format($total, 0, ',', '.') ?></strong></td>
            <td></td>
        </tr>
    </table>
    <br>
    <a class="vaciar_carrito" href="/tienda_motos/Tienda/carrito" onclick="return confirm('¿Vaciar el carrito?')">🗑️ Vaciar carrito</a>
<?php endif; ?>

<script>
// Activa edición por fila
function activarEdicion(id) {
    document.getElementById('cantidad-texto-' + id).style.display = 'none';
    document.getElementById('cantidad-input-' + id).style.display = 'inline-block';
    document.getElementById('guardar-btn-' + id).style.display = 'inline-block';
}
</script>

</div>

<?php include 'views/layouts/footer.php'; ?>
