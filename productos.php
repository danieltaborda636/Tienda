<?php
session_start();

$mensaje = "";

if (!isset($_SESSION['usuario'])) {
    die("Es necesario iniciar sesión para hacer un pedido.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $departamento = $_POST['departamento'];
    $contacto = $_POST['contacto'];
    $usuario_id = $_SESSION['usuario']['id'];

    if (empty($direccion) || empty($ciudad) || empty($departamento) || empty($contacto)) {
        $mensaje = "Todos los campos son obligatorios.</p>";
    } else {
        $conexion = new mysqli("localhost", "root", "", "tienda_sena");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $sql = "INSERT INTO pedidos (usuario_id, direccion, ciudad, departamento, contacto)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("issss", $usuario_id, $direccion, $ciudad, $departamento, $contacto);

         if ($stmt->execute()) {
            $mensaje = "Pedido confirmado.</p>";
            unset($_SESSION['carrito']); 
        } else {
            $mensaje = "Error al guardar el pedido.</p>";
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
    <link rel="stylesheet" href="assets/css/gestionproducto.css">
</head>
<body>


    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($mensaje)) {
        echo $mensaje;
    }
    ?>


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

        <input type="text" name="direccion" placeholder="Dirección" required><br>
        <input type="text" name="ciudad" placeholder="Ciudad" required><br>
        <input type="text" name="departamento" placeholder="Departamento" required><br>
        <input type="text" name="contacto" placeholder="Número de Contacto" required><br>
        <button type="submit">Confirmar Pedido</button>
    </form>
</body>
</html>