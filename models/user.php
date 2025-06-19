<?php
class user {
    private $db;

    public function __construct() {
        require_once '../config/database.php';
        $this->db = Database::connect();
        // Para capturar excepciones de MySQL
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

    public function registrar($Nombre, $Apellidos, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (nombre, apellidos, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssss", $Nombre, $Apellidos, $email, $passwordHash);

        try {
            return $stmt->execute(); // ✅ Registro exitoso
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                return "duplicado"; // ❌ Email ya registrado
            }
            return false; // ❌ Otro error
        }
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($password, $usuario['password'])) {
                return $usuario; // ✅ Login correcto
            }
        }

        return false; // ❌ Login incorrecto
    }
}
?>
