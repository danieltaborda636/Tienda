<div class="contenedor-principal">
    
<h2>Crear nuevo producto</h2>

<?php
// aca es la coneccion a la base de datos 
require_once __DIR__ . '/../../config/database.php'; 
$conexion = Database::connect();
$sql_categorias = "SELECT * FROM categorias";
$resultado_categorias = mysqli_query($conexion, $sql_categorias);
?>

<form action="?controller=productos&action=store" method="POST" enctype="multipart/form-data">     <!-- enctype="multipart/form-data" es para subir archivos -->

<!-- aca comiensa el formulario-->
    <div class="formularioProducto">
        <div>
            <label for="nombre">Nombre del producto:</label><br>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <br>
        <div>
            <label for="descripcion-producto">Descripción:</label><br>
            <textarea id="descripcion-producto" name="descripcion-producto" rows="4" cols="50" required></textarea>
        </div>
        <br>
        <div>
            <label for="precio">Precio:</label><br>
            <input type="number" id="precio" name="precio" step="0.01" required>
        </div>
        <br>
        <div>
            <label for="stock">Stock:</label><br>
            <input type="number" id="stock" name="stock" required>
        </div>
        <br>
        <div>
            <label for="oferta">¿Está en oferta?</label><br>
            <select id="oferta" name="oferta">
                <option value="SI">Sí</option>
                <option value="NO">No</option>
            </select>
        </div>
        <br>
<!--aca con ese select salen las categorias que ya estan creadas en la base de datos -->
        <div>
            <label for="categoria_id">Categoría:</label><br>
            <select id="categoria_id" name="categoria_id" required>
                <option value="" < Selecciona una categoría > </option>
                <?php while ($cat = $resultado_categorias->fetch_assoc()) : ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <br>
        <div>
            <label for="img">Imagen del producto:</label><br>
            <!-- accept="image/*": Solo acepta archivos que sean imágenes (jpg, png, gif)-->
            <input type="file" id="img" name="img" accept="image/*" required>
        </div>
        <br>
        <!-- Botón para enviar el formulario -->
        <button type="submit">Guardar producto</button>
    </div>
</form>