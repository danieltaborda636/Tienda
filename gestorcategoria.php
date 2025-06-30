<?php
session_start();
require_once '../basedatos/database.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Insertar nueva categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $sql = "INSERT INTO categorias (nombre) VALUES ('$nombre')";
    mysqli_query($conexion, $sql);
    header("Location: categorias.php");
    exit();
}

// Actualizar categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    $id = (int) $_GET['editar'];
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $sql = "UPDATE categorias SET nombre='$nombre' WHERE id=$id";
    mysqli_query($conexion, $sql);
    header("Location: categorias.php");
    exit();
}

// Eliminar categoría
if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];
    $sql = "DELETE FROM categorias WHERE id=$id";
    mysqli_query($conexion, $sql);
    header("Location: categorias.php");
    exit();
}

// Obtener todas las categorías
function obtenerCategorias($conexion) {
    $sql = "SELECT * FROM categorias ORDER BY id DESC";
    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

// Obtener una sola categoría por ID
function obtenerCategoriaPorId($conexion, $id) {
    $id = (int)$id;
    $sql = "SELECT * FROM categorias WHERE id=$id LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($resultado);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestor de Categorías</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        form { margin-top: 20px; }
        input[type="text"] { padding: 5px; width: 200px; }
        button { padding: 5px 10px; }
        .acciones a { margin: 0 5px; text-decoration: none; }
    </style>
</head>
<body>

<h2>Gestor de Categorías</h2>

<!-- Listado de categorías -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach(obtenerCategorias($conexion) as $categoria): ?>
            <tr>
                <td><?= $categoria['id'] ?></td>
                <td><?= htmlspecialchars($categoria['nombre']) ?></td>
                <td class="acciones">
                    <a href="categorias.php?editar=<?= $categoria['id'] ?>">✏️ Editar</a>
                    <a href="categorias.php?eliminar=<?= $categoria['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar esta categoría?')">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Formulario crear nueva categoría -->
<?php if (!isset($_GET['editar'])): ?>
    <h3>Crear nueva categoría</h3>
    <form method="POST" action="categorias.php">
        <input type="text" name="nombre" placeholder="Nombre de la categoría" required>
        <button type="submit" name="crear">Crear</button>
    </form>
<?php endif; ?>

<!-- Formulario editar categoría -->
<?php if (isset($_GET['editar'])): ?>
    <?php 
    $categoria = obtenerCategoriaPorId($conexion, $_GET['editar']);
    if (!$categoria): ?>
        <p style="color: red;">⚠️ Categoría no encontrada.</p>
    <?php else: ?>
        <h3>Editar categoría: <?= htmlspecialchars($categoria['nombre']) ?></h3>
        <form method="POST" action="categorias.php?editar=<?= $categoria['id'] ?>">
            <input type="text" name="nombre" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
            <button type="submit" name="actualizar">Actualizar</button>
            <a href="categorias.php">Cancelar</a>
        </form>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
