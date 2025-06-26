
    <title>Registro</title>
    <link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/style.css">
    <div class="container">
  
          <h1 class="titulos">Registrate</h1>
          

         <?php if (isset($_GET['registro'])): ?>
          <div class="mensaje">
              <?php if ($_GET['registro'] == 'exito'): ?>
                  <p class="mensaje-exito">Registro exitoso</p>
                  <?php header("refresh: 2; URL=./index.php"); ?>
              <?php elseif ($_GET['registro'] == 'error'): ?>
                  <p class="mensaje-error">Error al registrar</p>
                   <?php elseif ($_GET['registro'] == 'duplicado'): ?>
            <p class="mensaje-error">El correo ya está registrado</p>
              <?php endif; ?>
                <?php if ($_GET['registro'] == 'campos_invalidos'): ?>
                  <p class="mensaje-campos">Por favor, completa todos los campos.</p>
                  <?php endif; ?>
    
          </div>
          <?php endif; ?>


          <form action="<?= base_url ?>/controllers/UserController.php" method="POST">
            <p class="parrafos">Nombre:</p></br>
            <input type="text" placeholder="  Nombre completo" name="Nombre">
            <p class="parrafos">Apellido:</p>
            <input type="text" placeholder=" Apellido" name="Apellidos">
            <p class="parrafos">Email:</p>
            <input type="email"placeholder=" Gmail"  name="email">
            <p class="parrafos">Contraseña:</p>
            <input type="password" placeholder="  Contraseña" name="password">
                </br>
        
            <button class="btn-iniciar"type="submit" name="enviar">Registrar</button>
            <a href="<?=base_url?>/index.php">atras</a>
        
          </form>
      

    </div>




