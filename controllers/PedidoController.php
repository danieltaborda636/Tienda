<?php
session_start();

// Incluir clase de conexión
require_once __DIR__ . '/../config/database.php';

class PedidoController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect(); // ⬅️ Aquí se obtiene la conexión
    }

    public function mostrarPedidos()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            echo "Acceso denegado.";
            exit;
        }

        $sql = "SELECT * FROM pedidos ORDER BY fecha DESC";
        $resultado = $this->db->query($sql);

        include __DIR__ . '/../views/ver_pedidos.php';
    }

    public function cambiarEstado($id, $estado)
    {
        if (in_array($estado, ['aceptado', 'cancelado'])) {
            $stmt = $this->db->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
            $stmt->bind_param("si", $estado, $id);
            $stmt->execute();
        }

        header("Location: PedidoController.php?action=ver");
        exit;
    }
}

// Enrutador
$action = $_GET['action'] ?? '';

$controller = new PedidoController();

if ($action === 'ver') {
    $controller->mostrarPedidos();
} elseif ($action === 'estado' && isset($_GET['id']) && isset($_GET['estado'])) {
    $controller->cambiarEstado((int) $_GET['id'], $_GET['estado']);
} else {
    echo "Acción no válida.";
}
