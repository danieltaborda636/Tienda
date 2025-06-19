<title>Crear categoria</title>
<link rel="stylesheet" href="<?= base_url ?>/assets/css/style.css">

<div class="cont">
    <h1>Nueva Categoria</h1>

   <?php if (isset($_GET['categoria'])): ?>
    <p>
        <?php
        switch ($_GET['categoria']) {
            case 'exito':
                echo "Categoría registrada correctamente.";
                break;
            case 'duplicado':
                echo "La categoría ya existe.";
                break;
            case 'error':
                echo "Ocurrió un error al registrar la categoría.";
                break;
            case 'campos_invalidos':
                echo "Por favor, ingrese un nombre válido.";
                break;
        }
        ?>
    </p>
<?php endif; ?>


    <form action="<?= base_url ?>/controllers/categoryController.php" method="POST">
        <p class="parrafos">Nombre de la nueva categoria :</p>
        <input type="text" name="categoria" placeholder="Nombre de categoria" required>

        <button class="btn-iniciar" type="submit">Crear Categoria</button>
    </form>

</div>