<?php
include 'config/database.php';
include 'views/layouts/header.php';
?>
<link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/inicio.css">
<div class="contenedor">
    <ul>
        <li><a class="text" href="./views/user/login.php">iniciar sesion</a></li>
       
     <li><a href="?registro=1">Registrarse</a></li>
        <?php
        if (isset($_GET['registro'])) {
            include './views/user/register.php';
        }
        ?>  
    </ul>




</div>

<?php include 'views/layouts/footer.php'; ?>
