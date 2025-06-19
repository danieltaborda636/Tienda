<?php
class Database {
    public static function connect() {
        if (!defined('DB_SERVIDOR')) define('DB_SERVIDOR', 'localhost');
        if (!defined('DB_USUARIO')) define('DB_USUARIO', 'root');
        if (!defined('DB_CONTRASENA')) define('DB_CONTRASENA', '');
        if (!defined('DB_NOMBRE')) define('DB_NOMBRE', 'tienda_sena');

        $conexion = mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_CONTRASENA , DB_NOMBRE);

        if ($conexion === false) {
            die("Error: no se puede conectar" . mysqli_connect_error());
        }

        return $conexion;
    }
}
