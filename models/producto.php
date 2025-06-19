<?php
// Esta clase sirve para manejar los productos de la tienda de motos (guardar y consultar)
class producto {
    // Esta variable guarda la conexión con la base de datos
    private $db;

    // Cuando se crea un producto cuando usamos new producto(), se conecta a la base de datos
    public function __construct() {
        // Aquí usamos la clase Database que ya tenemos para conectarnos
        $this->db = Database::connect();
    }

    // Esta función guarda un producto nuevo en la base de datos
    public function crear($categoria_id, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $imagen) {
        // Escribimos el INSERT para meter los datos en la tabla productos
        $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparamos la consulta (esto hace que sea más segura)
        $stmt = $this->db->prepare($sql);

        // Aquí pasamos los datos reales al SQL (los que vienen del formulario)
        $stmt->bind_param("isssdsss", $categoria_id, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $imagen);

        // Ejecutamos la consulta. Si se guarda bien, devuelve true.
        return $stmt->execute();
    }

    // Esta función trae todos los productos que hay en la base de datos
    public function obtenerTodos() {
        // SQL para traer todo lo que hay en la tabla productos, ordenado del más nuevo al más viejo
        $sql = "SELECT * FROM productos ORDER BY id DESC";

        // Ejecutamos esa consulta
        $resultado = $this->db->query($sql);

        // Devolvemos el resultado para que se pueda usar con un while y mostrarlos
        return $resultado;
    }
}
