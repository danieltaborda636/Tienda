<?php
include 'views/layouts/header.php';
require_once 'config/database.php';
$conexion = Database::connect();
mysqli_report(MYSQLI_REPORT_OFF); // Desactiva warnings fatales

// Funciones
function obtenerProductos($conexion) {
    $sql = "SELECT p.*, c.nombre AS categoria FROM productos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id";
    $result = $conexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerProductoPorId($conexion, $id) {
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function eliminarProducto($conexion, $id) {
    try {
        $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

function actualizarProducto($conexion, $id, $nombre, $descripcion, $precio, $categoria_id) {
    $stmt = $conexion->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, categoria_id=? WHERE id=?");
    $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $categoria_id, $id);
    return $stmt->execute();
}

function obtenerCategorias($conexion) {
    $sql = "SELECT * FROM categorias";
    $result = $conexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Acciones
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    if (eliminarProducto($conexion, $id)) {
        header("Location: productos.php");
        exit();
    } else {
        echo "<script>alert('No se puede eliminar este producto porque está relacionado con otros registros.');</script>";
    }
}

if (isset($_POST['guardar_edicion'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval(str_replace(',', '.', $_POST['precio']));
    $categoria_id = intval($_POST['categoria_id']);

    if (actualizarProducto($conexion, $id, $nombre, $descripcion, $precio, $categoria_id)) {
        header("Location: productos.php");
        exit();
    } else {
        echo "<script>alert('Error al editar el producto.');</script>";
    }
}

$productos = obtenerProductos($conexion);
$categorias = obtenerCategorias($conexion);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/product.css">
    <title>Gestión de Productos</title>
</head>
<body>

<h2>Productos</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Categoría</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($productos as $prod): ?>
        <tr>
            <td><?= $prod['id'] ?></td>
            <td><?= htmlspecialchars($prod['nombre']) ?></td>
            <td><?= htmlspecialchars($prod['descripcion']) ?></td>
            <td><?= number_format($prod['precio'], 2) ?></td>
            <td><?= htmlspecialchars($prod['categoria']) ?></td>
            <td>
                <a href="productos.php?editar=<?= $prod['id'] ?>">Editar</a> |
                <a href="productos.php?eliminar=<?= $prod['id'] ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php if (isset($_GET['editar'])): 
    $productoEditar = obtenerProductoPorId($conexion, intval($_GET['editar']));
?>
    <h3>Editar Producto</h3>
    <form method="post">
        <input type="hidden" name="id" value="<?= $productoEditar['id'] ?>">

        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($productoEditar['nombre']) ?>" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" required><?= htmlspecialchars($productoEditar['descripcion']) ?></textarea><br><br>

        <label>Precio:</label><br>
        <input type="number" step="0.01" name="precio" value="<?= number_format($productoEditar['precio'], 2, '.', '') ?>" required><br><br>

        <label>Categoría:</label><br>
        <select name="categoria_id" required>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $productoEditar['categoria_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" name="guardar_edicion" value="Guardar Cambios">
    </form>
<?php endif; ?>

</body>
</html>

<?php include 'views/layouts/footer.php'; ?>
