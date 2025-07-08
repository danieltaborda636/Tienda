<div class="Todo">
<?php 
include '../layouts/header.php';
include '../../config/parametros.php';
?>
    <br><br>
    <title>Registro</title>
    <link rel="stylesheet" href="/tienda_motos/tienda/assets/css/registrar.css">
    <?php if (isset($_GET['registro'])): ?>
          <div class="mensaje">
              <?php if ($_GET['registro'] == 'exito'): ?>
                  <p class="mensaje-exito">Registro exitoso</p>
                  <?php header("refresh: 2; URL= ./../user/login.php"); ?>
              <?php elseif ($_GET['registro'] == 'error'): ?>
                  <p class="mensaje-error">Error al registrar</p>
                   <?php elseif ($_GET['registro'] == 'duplicado'): ?>
            <p class="mensaje-error">El correo ya está registrado.</p>
              <?php endif; ?>
                <?php if ($_GET['registro'] == 'campos_invalidos'): ?>
                  <p class="mensaje-campos">Por favor, completa todos los campos.</p>
                  <?php endif; ?>
    
          </div>
          <?php endif; ?>
          <div class="formulario">
        <img class="imagen-moto" src="../../assets/img/R1.jpeg" alt="">
        
          <h1 class="titulos">Registrate</h1>
          <form action="<?= base_url ?>/controllers/UserController.php" method="POST">
            <p class="parrafos">Nombre:</p></br>
            <input type="text" placeholder="  Nombre completo" name="Nombre">
            <p class="parrafos">Apellido:</p>
            <input type="text" placeholder=" Apellido" name="Apellidos">
            <p class="parrafos">Email:</p>
            <input type="email"placeholder=" Gmail"  name="email">
            <p class="parrafos">Contraseña:</p>
            <input type="password" placeholder="  Contraseña" name="password">
            </br><br>
            <button class="btn-registrar"type="submit" name="enviar">Registrar</button>
            <button class="btn-atras"><a href="../../index.php">Atrás</a></button>
            <!-- <button><a href="index.php"></a>Atras</button> -->
            <!-- <button type="button" onclick="window.location.href='../../../index.php'">Atrás</button> -->
          
             
          </form>
    </div>
<?php 
include '../layouts/footer.php'
?>
</div>
