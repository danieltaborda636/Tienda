
    <title>Registro</title>
    <link rel="stylesheet" href="http://localhost/tienda_motos/Tienda/assets/css/style.css">
    <div class="container">
  
          <h1>Registrate</h1>

         <?php if (isset($_GET['registro'])): ?>
          <div class="mensaje">
              <?php if ($_GET['registro'] == 'exito'): ?>
                  <p class="mensaje-exito">Registro exitoso</p>
              <?php elseif ($_GET['registro'] == 'error'): ?>
                  <p class="mensaje-error">Error al registrar</p>
              <?php endif; ?>
          </div>
          <?php endif; ?>


          <form action="{URL}/controllers/UserController.php" method="POST">
            <p class="parrafos">Nombre:</p></br>
            <input type="text" placeholder="  Nombre completo" name="Nombre">
            <p class="parrafos">Apellido:</p>
            <input type="text" placeholder=" Apellido" name="Apellidos">
            <p class="parrafos">Email:</p>
            <input type="email"placeholder=" Gmail"  name="email">
            <p class="parrafos">Contraseña:</p>
            <input type="password" placeholder="  Contraseña" name="password">
        
            <button class="btn-iniciar"type="submit" name="enviar">Registrar</button>
          </form>
      

    </div>

