<div>
<?php 
include '../layouts/header.php';
include '../../config/parametros.php';
?>
<title>Iniciar Sesión</title>
<link rel="stylesheet" href="<?= base_url ?>/assets/css/login.css">

<div class="container">
    <h1>Iniciar sesión</h1>

    <?php if (isset($_GET['login'])): ?>
        <div class="mensaje">
            <?php if ($_GET['login'] == 'error'): ?>
                <p class="mensaje-error">Email o contraseña incorrectos.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url ?>/controllers/UserController.php" method="POST">
        <p class="parrafos">Correo electrónico:</p>
        <input type="email" name="email" placeholder="Gmail" required>

        <p class="parrafos">Contraseña:</p>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button class="btn-iniciar" type="submit" name="login">Iniciar sesión</button><br>
        <button class="btn-atras" onclick="location.href='<?=base_url?>/index.php'">Atrás</button>
    </form>

</div>

<?php 
include '../layouts/footer.php'
?>
</div>

