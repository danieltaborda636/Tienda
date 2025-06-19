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

<?php
// Miramos si en la URL hay algo como ?controller=algo&action=otraCosa
if (isset($_GET['controller']) && isset($_GET['action'])) {
    // Guardamos el nombre del controlador y lo que queremos que haga (la acción)
    $nombreControlador = $_GET['controller'];
    $accion = $_GET['action'];

    // Buscamos el archivo del controlador según lo que vino en la URL
    $archivo = 'controllers/controlador-' . $nombreControlador . '.php';

    // Le ponemos Controlador al principio para formar el nombre de la clase
    $clase = 'Controlador' . ucfirst($nombreControlador); 

    // Si ese archivo sí existe en la carpeta, lo usamos
    if (file_exists($archivo)) {
        require_once $archivo;

        // Creamos un nuevo objeto del controlador (como prenderlo pa que funcione)
        $controlador = new $clase();

        // Revisamos si ese controlador tiene la funcion que pedimos (como create o store)
        if (method_exists($controlador, $accion)) {
            $controlador->$accion(); // Aquí ya hacemos que se ejecute esa funcion, como guardar o mostrar
        } else {
            echo "<p> Esa función '$accion' no existe en ese controlador.</p>";
        }
    } else {
        echo "<p> No encontramos ese controlador llamado '$archivo'.</p>";
    }
}
?>



</div>

<?php include 'views/layouts/footer.php'; ?>
