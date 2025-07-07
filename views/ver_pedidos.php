<h2>Lista de pedidos</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Dirección</th>
        <th>Ciudad</th>
        <th>Departamento</th>
        <th>Contacto</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Acciones</th>
    </tr>
    <?php while ($pedido = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?= $pedido['id'] ?></td>
        <td><?= $pedido['usuario_id'] ?></td>
        <td><?= $pedido['direccion'] ?></td>
        <td><?= $pedido['ciudad'] ?></td>
        <td><?= $pedido['departamento'] ?></td>
        <td><?= $pedido['contacto'] ?></td>
        <td><?= ucfirst($pedido['estado']) ?></td>
        <td><?= $pedido['fecha'] ?></td>
        <td>
            <?php if ($pedido['estado'] === 'pendiente'): ?>
                <a href="../controllers/PedidoController.php?action=estado&id=<?= $pedido['id'] ?>&estado=aceptado">✅ Aceptar</a>
                |
                <a href="../controllers/PedidoController.php?action=estado&id=<?= $pedido['id'] ?>&estado=cancelado">❌ Cancelar</a>
            <?php else: ?>
                <?= ucfirst($pedido['estado']) ?>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
