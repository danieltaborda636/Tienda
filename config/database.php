<?php
/*guardar la configuracion de la base de datos     */
class Database{
    public static function connect(){
        define('DB_SERVIDOR','localhost');
        define('DB_USUARIO','root');
        define('DB_CONTRASENA','');
        define('DB_NOMBRE','tienda_sena');

        //crear la conexion a la DB
        $conexion = mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_CONTRASENA , DB_NOMBRE);   // ESTE ES EL ORDDEN QUE DEBE DE LLEVAR

        //revisar la conexion
        if($conexion === false){
            die("Error: no se puede conectar" . mysqli_connect_error());

        }
        return $conexion;
    }
}
?>