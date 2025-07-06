<?php
class Database {
    private static $conexion = null;

    public static function connect() {
        if (self::$conexion === null) {
            $host = 'localhost';
            $usuario = 'root';
            $contrasena = '';
            $nombreBD = 'tienda_sena';

            self::$conexion = new mysqli($host, $usuario, $contrasena, $nombreBD);

            if (self::$conexion->connect_error) {
                die("Error de conexión: " . self::$conexion->connect_error);
            }

            // Opcional: establecer codificación utf8
            self::$conexion->set_charset("utf8");
        }

        return self::$conexion;
    }
}
