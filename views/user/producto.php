<?php
require_once __DIR__ . '/../../models/product.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $product = new Product();
    $producto = $product->obtenerPorId($id);

    if ($producto):
?>
    <!-- Vincula el CSS para estilos del producto -->
    <link rel="stylesheet" href="/tienda_motos/Tienda/assets/css/producto.css">

    <div class="detalle-producto">
        <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
        
        <img src="archivos-subidos/productos/<?= htmlspecialchars($producto['imagen']) ?>" 
             alt="<?= htmlspecialchars($producto['nombre']) ?>">

        <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
        <p><strong>Precio:</strong> $<?= number_format($producto['precio'], 0, ',', '.') ?></p>
        <p><strong>Categoría:</strong> <?= htmlspecialchars($producto['categoria_nombre']) ?></p>
        <p><strong>Stock disponible:</strong> <?= intval($producto['stock']) ?> unidades</p>

        <?php if ($producto['stock'] > 0): ?>
            <a href="?view=carrito&agregar=<?= $producto['id'] ?>" class="btn">Agregar al carrito</a>
        <?php else: ?>
            <p class="sin-stock">🚫 Producto agotado</p>
        <?php endif; ?>
    </div>

<?php
    else:
?>
    <div class="alerta">
        <strong>⚠️ Error:</strong> Producto no encontrado.
    </div>
<?php
    endif;
} else {
?>
    <div class="alerta">
        <strong>⚠️ Error:</strong> No se especificó un producto.
    </div>
<?php
}
?>
