
<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/style.css">

<!-- Mostrar mensajes según el resultado del controlador -->
<?php if (isset($_GET['mensaje'])): ?>
    <div style="padding:10px; margin-bottom:15px; border-radius:5px;">
        <?php
            switch ($_GET['mensaje']) {
                case 'ok':
                    echo "<p style='color:green;'>Producto guardado correctamente.</p>";
                    break;
                case 'error_bd':
                    echo "<p style='color:red;'>Error al guardar el producto en la base de datos.</p>";
                    break;
                case 'fallo_subida':
                    echo "<p style='color:red;'>La imagen no se pudo subir.</p>";
                    break;
                case 'tipo_no_valido':
                    echo "<p style='color:red;'>El archivo subido no es una imagen válida (solo JPG, PNG o GIF).</p>";
                    break;
                case 'error_imagen':
                    echo "<p style='color:red;'>Hubo un problema al subir la imagen.</p>";
                    break;
                case 'faltan_campos':
                    echo "<p style='color:red;'>Todos los campos deben estar llenos.</p>";
                    break;
                default:
                    echo "<p style='color:orange;'>Ocurrió un error inesperado.</p>";
                    break;
            }
        ?>
    </div>
<?php endif; ?>

<?php
// Conexión a la base de datos y obtención de categorías
require_once __DIR__ . '/../../config/database.php'; 
$conexion = Database::connect();
$sql_categorias = "SELECT * FROM categorias";
$resultado_categorias = mysqli_query($conexion, $sql_categorias);
?>

<!-- Formulario de creación de producto -->
<div class="contenedorproducto">
    <h2>Crear nuevo producto</h2>
    <form action="?controller=productos&action=store" method="POST" enctype="multipart/form-data">
        <div class="formularioProducto">
            <div class="crear-producto">
                <label for="nombre">Nombre del producto:</label><br>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <br>

            <div class="crear-producto">
                <label for="descripcion_producto">Descripción:</label><br>
                <textarea id="descripcion_producto" name="descripcion_producto" rows="4" cols="50" required></textarea>
            </div>
            <br>

            <div class="crear-producto">
                <label for="precio">Precio:</label><br>
                <input type="number" id="precio" name="precio" step="0.01" min="0" required>
            </div>
            <br>

            <div class="crear-producto">
                <label for="stock">Stock:</label><br>
                <input type="number" id="stock" name="stock" min="0" required>
            </div>
            <br>

            <div class="crear-producto2">
                <label for="oferta">¿Está en oferta?</label><br>
                <select id="oferta" name="oferta">
                    <option value="SI">Sí</option>
                    <option value="NO">No</option>
                </select>
            </div>
            <br>

            <div class="crear-producto2">
                <label for="categoria_id">Categoría:</label><br>
                <select id="categoria_id" name="categoria_id" required>
                    <option value="">Selecciona una categoría</option>
                    <?php while ($cat = $resultado_categorias->fetch_assoc()) : ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nombre']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <br>

            <div class="crear-producto2">
                <label for="img">Imagen del producto:</label><br>
                <input type="file" id="img" name="img" accept="image/*" required>
            </div>
            <br>

            <button type="submit">Guardar producto</button>
        </div>
    </form>
</div>
