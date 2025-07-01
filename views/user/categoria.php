<div>
<?php 
include '../layouts/header.php';
include '../../config/parametros.php';
?>
<title>Crear categoria</title>
<link rel="stylesheet" href="<?= base_url ?>/assets/css/categorias.css">

<div class="contenedor">
    <h1>Nueva Categoria</h1>
    <form action="<?= base_url ?>/controllers/categoryController.php" method="POST">
        <p class="parrafos">Nombre de la nueva categoria :</p>
        <input type="text" name="categoria" placeholder="Nombre de categoria" required>

        <button class="btn-iniciar" type="submit">Crear Categoria</button>
    </form>

</div>
<?php 
include '../layouts/footer.php'
?>
</div>