 <?php
 class category{
    private $db;

    public function __construct() {
        require_once '../config/database.php';
        $this->db = Database::connect();
        // Para capturar excepciones de MySQL
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
       public function guardarCategoria($nombre) {
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        return $stmt->execute();
    }
}
?>

