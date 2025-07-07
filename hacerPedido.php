<?php
session_start();
include 'views/layouts/header.php';
$mensaje = "";

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión para hacer un pedido.";
    exit();
}

$usuario_id = $_SESSION['usuario']['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $contacto = $_POST['contacto'] ?? '';

    if (empty($direccion) || empty($ciudad) || empty($departamento) || empty($contacto)) {
        $mensaje = "Todos los campos son obligatorios.";
    } elseif (empty($_SESSION['carrito'])) {
        $mensaje = "Tu carrito está vacío.";
    } else {
        $conexion = new mysqli("localhost", "root", "", "tienda_sena");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $sqlPedido = "INSERT INTO pedidos (usuario_id, direccion, ciudad, departamento, contacto) VALUES (?, ?, ?, ?, ?)";
        $stmtPedido = $conexion->prepare($sqlPedido);
        $stmtPedido->bind_param("issss", $usuario_id, $direccion, $ciudad, $departamento, $contacto);

        if ($stmtPedido->execute()) {
            $pedido_id = $stmtPedido->insert_id;
            $stmtPedido->close();

            $sqlLinea = "INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES (?, ?, ?)";
            $stmtLinea = $conexion->prepare($sqlLinea);

            foreach ($_SESSION['carrito'] as $producto) {
                $producto_id = $producto['id'];
                $cantidad = $producto['cantidad'];
                $stmtLinea->bind_param("iii", $pedido_id, $producto_id, $cantidad);
                $stmtLinea->execute();
            }

            $stmtLinea->close();
            $conexion->close();

            unset($_SESSION['carrito']);
            $mensaje = "¡Pedido realizado con éxito!";
        } else {
            $mensaje = "Error al guardar el pedido: " . $conexion->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hacer Pedido</title>
    <link rel="stylesheet" href="assets/css/pedido.css">
</head>
<body>

<h2>Hacer Pedido</h2>

<?php
if (!empty($mensaje)) {
    echo "<p>$mensaje</p>";
}
?>

<h3>Tu carrito:</h3>
<?php
if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        echo "{$item['cantidad']} x {$item['nombre']} - $" . number_format($item['precio']) . "<br>";
    }
} else {
    echo "Tu carrito está vacío.";
}
?>

<form method="POST" action="">
    <p><input type="text" name="direccion" placeholder="Dirección" required></p>
    <p><input type="text" name="ciudad" placeholder="Ciudad" required></p>
    <p><input type="text" name="departamento" placeholder="Departamento" required></p>
    <p><input type="text" name="contacto" placeholder="Número de Contacto" required></p>
    <p><button type="submit">Confirmar Pedido</button></p>
</form>

</body>
</html>
<?php include 'views/layouts/footer.php'; ?>