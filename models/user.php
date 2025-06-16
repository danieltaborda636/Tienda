<?php
class user {
    private $db;

    public function __construct() {
        require_once '../config/database.php';
        $this->db = Database::connect();
    }

    public function registrar($Nombre, $Apellidos, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (nombre, apellidos, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssss", $Nombre, $Apellidos, $email, $passwordHash);

        return $stmt->execute();
    }
}
?>
