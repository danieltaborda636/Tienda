<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/../../config/database.php';
$conexion = Database::connect();

// Obtener categorías
$sql = "SELECT * FROM categorias ORDER BY nombre ASC";
$categorias = mysqli_query($conexion, $sql);
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>VCJ MOTOS</title>
    <link rel="stylesheet" href="/tienda_motos/Tienda/assets/css/header.css">
</head>
<body>
    <header id="cabecera">
        <div class="logo">
            <a class="nombre" href="index.php">VCJ MOTOS</a>
        </div>

        <div class="container">
        <nav class="menu">
            <ul>
                <li><a href="http://localhost/tienda_motos/Tienda/index.php">Inicio</a></li>

                <?php if ($categorias && mysqli_num_rows($categorias) > 0): ?>
                    <?php while ($categoria = mysqli_fetch_assoc($categorias)): ?>
                        <li>
                            <a href="categoria.php?id=<?= $categoria['id']; ?>">
                                <?= htmlspecialchars($categoria['nombre']); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li>No hay categorías disponibles</li>
                <?php endif; ?>
            </ul>
        </nav>
        </div>

        <div class="clearfix"></div>
    </header>
