<?php
require_once __DIR__ . '/../config/database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Obtener todos los productos
    public function obtenerTodos() {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $resultado = $this->db->query($sql);
        return $resultado;
    }

    // Obtener un producto por ID (con categoría)
    public function obtenerPorId($id) {
        $id = $this->db->real_escape_string($id);
        $sql = "SELECT p.*, c.nombre AS categoria_nombre 
                FROM productos p
                INNER JOIN categorias c ON p.categoria_id = c.id
                WHERE p.id = $id LIMIT 1";
        $resultado = $this->db->query($sql);
        return $resultado->fetch_assoc();
    }
}
