<?php
session_start();
$carrito = $_SESSION['carrito'] ?? [];
?>

<h2>🛒 Carrito de Compras</h2>

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
    <a href="/tienda_motos/Tienda/controllers/carritoController.php?vaciar=1" onclick="return confirm('¿Vaciar el carrito?')">🗑️ Vaciar carrito</a>
<?php endif; ?>

<script>
// Activa edición por fila
function activarEdicion(id) {
    document.getElementById('cantidad-texto-' + id).style.display = 'none';
    document.getElementById('cantidad-input-' + id).style.display = 'inline-block';
    document.getElementById('guardar-btn-' + id).style.display = 'inline-block';
}
</script>
