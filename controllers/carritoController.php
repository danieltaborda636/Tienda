<?php
session_start();
require_once __DIR__ . '/../models/product.php';

$productModel = new Product();

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Limpiar mensaje anterior
unset($_SESSION['error_carrito']);

// Agregar producto al carrito
if (isset($_GET['agregar'])) {
    $id = intval($_GET['agregar']);
    $cantidad = isset($_GET['cantidad']) ? max(1, intval($_GET['cantidad'])) : 1;

    $producto = $productModel->obtenerPorId($id);

    if ($producto && $producto['stock'] > 0) {
        $stockDisponible = $producto['stock'];
        $cantidadActual = $_SESSION['carrito'][$id]['cantidad'] ?? 0;

        if ($cantidadActual + $cantidad > $stockDisponible) {
            $_SESSION['error_carrito'] = "No puedes agregar más de {$stockDisponible} unidades de «{$producto['nombre']}».";
        } else {
            $_SESSION['carrito'][$id] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidadActual + $cantidad,
                'imagen' => $producto['imagen']
            ];
        }
    }

    header('Location: ../views/carrito/ver.php');
    exit;
}

// Eliminar producto del carrito
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    unset($_SESSION['carrito'][$id]);
    header('Location: ../views/carrito/ver.php');
    exit;
}

// Vaciar carrito
if (isset($_GET['vaciar'])) {
    unset($_SESSION['carrito']);
    header('Location: ../views/carrito/ver.php');
    exit;
}

// Actualizar cantidades
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    foreach ($_POST['cantidades'] as $id => $cantidad) {
        $id = intval($id);
        $cantidad = max(1, intval($cantidad));

        if (isset($_SESSION['carrito'][$id])) {
            $producto = $productModel->obtenerPorId($id);
            if ($producto) {
                if ($cantidad > $producto['stock']) {
                    $_SESSION['error_carrito'] = "Stock insuficiente para «{$producto['nombre']}». Máximo disponible: {$producto['stock']}.";
                } else {
                    $_SESSION['carrito'][$id]['cantidad'] = $cantidad;
                }
            }
        }
    }

    header('Location: ../views/carrito/ver.php');
    exit;
}
