<?php
require_once './config/database.php';

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
}