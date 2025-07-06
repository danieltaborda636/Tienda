<?php
// Esta clase maneja la lógica relacionada con los productos
class Producto {
    private $db; // Conexión a la base de datos

    // Al crear una instancia de Producto, se conecta a la base de datos
    public function __construct() {
        require_once '../config/database.php'; // Asegúrate de que esta ruta sea correcta
        $this->db = Database::connect();
    }

    // Guarda un nuevo producto en la base de datos
    public function crear($categoria_id, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $imagen) {
        $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        // Revisamos si se preparó correctamente
        if (!$stmt) {
            return false;
        }

        // Convertimos tipos si es necesario
        $oferta = (string)$oferta;
        $fecha = (string)$fecha;

        // Enlazamos los parámetros. Tipos:
        // i = integer (categoria_id, stock)
        // d = double (precio)
        // s = string (nombre, descripcion, oferta, fecha, imagen)
        $stmt->bind_param("issdisss", $categoria_id, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $imagen);

        return $stmt->execute(); // Ejecutamos y retornamos el resultado (true o false)
    }

    // Devuelve todos los productos de la base de datos
    public function obtenerTodos() {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        return $this->db->query($sql);
    }

    // Puedes agregar más métodos luego (editar, eliminar, buscar por ID, etc.)
}
