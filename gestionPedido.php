<?php
session_start();
require_once 'config/database.php';
include 'views/layouts/header.php';

$conexion = Database::connect();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para obtener todos los pedidos
function obtenerPedidos($conexion) {
    $sql = "SELECT p.*, u.nombre AS nombre_usuario FROM pedidos p 
            JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha DESC";
    $result = $conexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Función para actualizar estado del pedido
function actualizarEstado($conexion, $pedido_id, $nuevo_estado) {
    $stmt = $conexion->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $nuevo_estado, $pedido_id);
    return $stmt->execute();
}

// Procesar actualización de estado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pedido_id'], $_POST['estado'])) {
    $pedido_id = intval($_POST['pedido_id']);
    $nuevo_estado = $_POST['estado'];
    actualizarEstado($conexion, $pedido_id, $nuevo_estado);
    header("Location: gestionpedido.php");
    exit();
}

// Obtener pedidos
$pedidos = obtenerPedidos($conexion);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pedidos</title>
<<<<<<< HEAD
    <!-- <link rel="stylesheet" href="assets/css/gestiopedido.css"> -->
=======
    <link rel="stylesheet" href="assets/css/tabla_gestion.css">
>>>>>>> 240e05dcc1a361fa8f9cdba50af3c6f57e11e66f
</head>
<body>
<div class="Todo">
    <h2>Gestión de Pedidos</h2>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Departamento</th>
            <th>Contacto</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?= $pedido['id'] ?></td>
                <td><?= htmlspecialchars($pedido['nombre_usuario']) ?></td>
                <td><?= htmlspecialchars($pedido['direccion']) ?></td>
                <td><?= htmlspecialchars($pedido['ciudad']) ?></td>
                <td><?= htmlspecialchars($pedido['departamento']) ?></td>
                <td><?= htmlspecialchars($pedido['contacto']) ?></td>
                <td><?= htmlspecialchars($pedido['estado']) ?></td>
                <td>
                    <form method="post" action="gestionpedido.php">
                        <input type="hidden" name="pedido_id" value="<?= $pedido['id'] ?>">
                        <select name="estado" required>
                            <option value="pendiente" <?= $pedido['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="aceptado" <?= $pedido['estado'] == 'aceptado' ? 'selected' : '' ?>>Aceptado</option>
                            <option value="rechazado" <?= $pedido['estado'] == 'rechazado' ? 'selected' : '' ?>>Rechazado</option>
                            <option value="enviado" <?= $pedido['estado'] == 'enviado' ? 'selected' : '' ?>>Enviado</option>
                            <option value="cancelado" <?= $pedido['estado'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                        </select>
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

<?php include 'views/layouts/footer.php'; ?>
