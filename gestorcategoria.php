<?php
session_start();
include 'config/database.php';
include 'config/parametros.php';
include 'views/layouts/header.php';

// FUNCIONES
function obtenerCategorias($conexion) {
    $sql = "SELECT * FROM categorias";
    $result = $conexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerCategoriaPorId($conexion, $id) {
    $stmt = $conexion->prepare("SELECT * FROM categorias WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function editarCategoria($conexion, $id, $nuevoNombre) {
    $stmt = $conexion->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
    $stmt->bind_param("si", $nuevoNombre, $id);
    return $stmt->execute();
}

function eliminarCategoria($conexion, $id) {
    $stmt = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// PROCESAR EDICIÓN
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['actualizar']) && isset($_POST['nombre']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $nuevoNombre = trim($_POST['nombre']);
    if (!empty($nuevoNombre)) {
        editarCategoria($conexion, $id, $nuevoNombre);
    }
    header("Location: categorias.php");
    exit();
}

// PROCESAR ELIMINACIÓN
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    eliminarCategoria($conexion, $id);
    header("Location: categorias.php");
    exit();
}

// OBTENER TODAS LAS CATEGORÍAS
$categorias = obtenerCategorias($conexion);
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
            <li><a class="text" href="categorias.php">Gestionar categorías</a></li><br>
            <li><a class="text" href="controllers/logout.php">Cerrar sesión</a></li>
        <?php else: ?>
            <li><p class="text">Bienvenido, <a class="tex"><?= $_SESSION['usuario']['nombre']; ?></a></p></li>
            <li><a class="text" href="#">Mis pedidos</a></li>
            <li><a class="text" href="#">Ver carrito</a></li>
            <li><a class="text" href="controllers/logout.php">Cerrar sesión</a></li>
        <?php endif; ?>
    </ul>

    <div class="contenedorproducto">
        <h2>Gestor de Categorías</h2>

        <?php if (isset($_GET['editar'])): ?>
            <?php $categoria = obtenerCategoriaPorId($conexion, intval($_GET['editar'])); ?>
            <?php if ($categoria): ?>
                <form method="POST" action="categorias.php">
                    <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                    <label>Editar nombre:</label><br>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
                    <button type="submit" name="actualizar">Actualizar</button>
                    <a href="categorias.php">Cancelar</a>
                </form>
            <?php else: ?>
                <p>Categoría no encontrada.</p>
            <?php endif; ?>
        <?php endif; ?>

        <h3>Categorías existentes</h3>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($categorias as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['nombre']) ?></td>
                    <td>
                        <a href="categorias.php?editar=<?= $cat['id'] ?>">✏️ Editar</a> |
                        <a href="categorias.php?eliminar=<?= $cat['id'] ?>" onclick="return confirm('¿Eliminar esta categoría?')">🗑️ Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
