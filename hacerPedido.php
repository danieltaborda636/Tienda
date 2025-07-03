
<?php
session_start();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $departamento = $_POST['departamento'];
    $contacto = $_POST['contacto'];

    if (empty($direccion) || empty($ciudad) || empty($departamento) || empty($contacto)) {
        $mensaje = "<p style='color:red;'>Todos los campos son obligatorios.</p>";
    } else {
        $conexion = new mysqli("localhost", "root", "", "tienda_sena");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $sql = "INSERT INTO pedidos (direccion, ciudad, departamento, contacto)
        VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $direccion, $ciudad, $departamento, $contacto);


        if ($stmt->execute()) {
            $mensaje = "Pedido confirmado correctamente.</p>";
            unset($_SESSION['carrito']); // Limpia el carrito
        } else {
            $mensaje = "<p style='color:red;'>Error al guardar el pedido.</p>";
        }

        $stmt->close();
        $conexion->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hacer Pedido</title>


</head>
<body>
    <form class="formulario" method="POST" action="">
        <h2>Hacer Pedido</h2>

        <div class="carrito">
            <strong>Productos en el carrito:</strong><br>
            <?php
            if (!empty($_SESSION['carrito'])) {
                foreach ($_SESSION['carrito'] as $item) {
                    echo "<p>{$item['cantidad']} x {$item['nombre']} - $" . number_format($item['precio']) . "</p>";
                }
            } else {
                echo "<p>No hay productos en el carrito.</p>";
            }
            ?>
        </div>
    <h2>Hacer Pedido</h2>
    <form action="procesar_pedido.php" method="POST">
        <input type="text" name="direccion" placeholder="Dirección" required><br>
        <input type="text" name="ciudad" placeholder="Ciudad" required><br>
        <input type="text" name="departamento" placeholder="Departamento" required><br>
        <input type="text" name="contacto" placeholder="Número de Contacto" required><br>
        <button type="submit">Confirmar Pedido</button>
    </form>