<?php
require_once __DIR__ . '/../../models/product.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $product = new Product();
    $producto = $product->obtenerPorId($id);

    if ($producto):
?>
    <link rel="stylesheet" href="/tienda_motos/Tienda/assets/css/producto.css">

    <div class="detalle-producto">
        <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
        
        <img src="/tienda_motos/Tienda/uploads/productos/<?= htmlspecialchars($producto['imagen']) ?>" 
             alt="<?= htmlspecialchars($producto['nombre']) ?>" 
             onerror="this.onerror=null; this.src='/tienda_motos/Tienda/assets/img/no-image.png';">

        <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
        <p><strong>Precio:</strong> $<?= number_format($producto['precio'], 0, ',', '.') ?></p>
        <p><strong>Categoría:</strong> <?= htmlspecialchars($producto['categoria_nombre']) ?></p>
        <p><strong>Stock disponible:</strong> <?= intval($producto['stock']) ?> unidades</p>

        <?php if ($producto['stock'] > 0): ?>
            <form action="/tienda_motos/Tienda/controllers/carritoController.php" method="get" id="form-carrito">
                <input type="hidden" name="agregar" value="<?= $producto['id'] ?>">

                <div id="contenedor-cantidad" style="display: none; margin-top: 10px;">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" value="1"
                           min="1" max="<?= $producto['stock'] ?>" required>
                </div>

                <button type="button" class="btn" onclick="manejarAgregar()">Agregar al carrito</button>
            </form>
        <?php else: ?>
            <p class="sin-stock">🚫 Producto agotado</p>
        <?php endif; ?>
    </div>

    <script>
    let cantidadVisible = false;

    function manejarAgregar() {
        const contenedorCantidad = document.getElementById("contenedor-cantidad");
        const inputCantidad = document.getElementById("cantidad");
        const max = parseInt(inputCantidad.max);

        if (!cantidadVisible) {
            contenedorCantidad.style.display = "block";
            cantidadVisible = true;
            inputCantidad.focus();
            return;
        }

        const cantidad = parseInt(inputCantidad.value);
        if (!cantidad || cantidad < 1) {
            alert("Por favor ingresa una cantidad válida.");
            return;
        }

        if (cantidad > max) {
            alert("⚠️ No puedes agregar más del stock disponible (" + max + ").");
            return;
        }

        document.getElementById("form-carrito").submit();
    }
    </script>

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
