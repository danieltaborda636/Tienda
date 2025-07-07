<?php
session_start();
require_once 'config/database.php';
include 'config/parametros.php';
include 'views/layouts/header.php';

$conexion = Database::connect();

// Mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Funciones
function obtenerCategorias($conexion) {
    $sql = "SELECT * FROM categorias";
    $result = $conexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function eliminarCategoria($conexion, $id) {
    $stmt = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function editarCategoria($conexion, $id, $nuevoNombre) {
    $stmt = $conexion->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
    $stmt->bind_param("si", $nuevoNombre, $id);
    return $stmt->execute();
}

// Procesar edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['nombre'])) {
    $id = intval($_POST['id']);
    $nuevoNombre = trim($_POST['nombre']);
    editarCategoria($conexion, $id, $nuevoNombre);
    header("Location: categorias.php");
    exit();
}

// Procesar eliminación
$mensaje = '';
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    if (!eliminarCategoria($conexion, $id)) {
        $mensaje = "❌ No se puede eliminar la categoría porque tiene productos asociados.";
    } else {
        header("Location: categorias.php");
        exit();
    }
}

$categorias = obtenerCategorias($conexion);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Categorías</title>
    <link rel="stylesheet" href="assets/css/gestioncategoria.css">
</head>
<body>
    <h2>Categorías</h2>

    <?php if (!empty($mensaje)): ?>
        <p style="color: red;"><?= $mensaje ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['editar'])): 
        $editarId = intval($_GET['editar']);
        $categoriaEditar = null;
        foreach ($categorias as $cat) {
            if ($cat['id'] == $editarId) {
                $categoriaEditar = $cat;
                break;
            }
        }
    ?>
        <?php if ($categoriaEditar): ?>
            <h3>Editar Categoría</h3>
            <form method="post" action="categorias.php">
                <input type="hidden" name="id" value="<?= $categoriaEditar['id'] ?>">
                <input type="text" name="nombre" value="<?= htmlspecialchars($categoriaEditar['nombre']) ?>" required>
                <button type="submit">Guardar Cambios</button>
                <a href="categorias.php">Cancelar</a>
            </form>
        <?php else: ?>
            <p style="color: red;">Categoría no encontrada.</p>
        <?php endif; ?>
        <hr>
    <?php endif; ?>

    <table border="1" cellpadding="5" cellspacing="0">
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
                    <a href="categorias.php?editar=<?= $cat['id'] ?>">Editar</a> |
                    <a href="categorias.php?eliminar=<?= $cat['id'] ?>" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

<?php include 'views/layouts/footer.php'; ?>
