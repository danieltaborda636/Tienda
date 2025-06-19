<?php
session_start();
ob_start(); // Opcional, pero útil para evitar errores de encabezado

require_once '../models/category.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
    $nombreCategoria = trim($_POST['categoria']);

    if (empty($nombreCategoria)) {
        header("Location: ../index.php?view=categoria&categoria=campos_invalidos");
        exit;
    }

    $category = new Category();
    $resultado = $category->guardarCategoria($nombreCategoria);

    if ($resultado === true) {
        header("Location: ../index.php?view=categoria&categoria=exito");
        exit;
    } elseif ($resultado === "duplicado") {
        header("Location: ../index.php?view=categoria&categoria=duplicado");
        exit;
    } else {
        header("Location: ../index.php?view=categoria&categoria=error");
        exit;
    }
}