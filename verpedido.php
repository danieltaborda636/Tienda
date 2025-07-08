<?php
session_start();
include 'config/database.php';
include 'views/layouts/header.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario']['id'];

// Consulta para obtener los pedidos del usuario actual
$stmt = $conexion->prepare("SELECT * FROM pedidos WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<h2>Mis Pedidos</h2>
<link rel="stylesheet" href="assets/css/verpedido.css">
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Departamento</th>
            <th>Contacto</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($pedido = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $pedido['id'] ?></td>
                <td><?= htmlspecialchars($pedido['direccion']) ?></td>
                <td><?= htmlspecialchars($pedido['ciudad']) ?></td>
                <td><?= htmlspecialchars($pedido['departamento']) ?></td>
                <td><?= htmlspecialchars($pedido['contacto']) ?></td>
                <td><?= $pedido['fecha'] ?></td>
                <td><?= $pedido['estado'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'views/layouts/footer.php'; ?>
