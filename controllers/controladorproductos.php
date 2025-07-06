<?php
require_once '../config/database.php';
require_once '../models/Producto.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = $_POST['nombre'] ?? null;
                $descripcion = $_POST['descripcion_producto'] ?? null;
                $precio = $_POST['precio'] ?? null;
                $stock = $_POST['stock'] ?? null;
                $oferta = $_POST['oferta'] ?? 'NO';
                $categoria_id = $_POST['categoria_id'] ?? null;
                $imagen = $_FILES['img'] ?? null;

                // Validar que no falten campos
                if (!$nombre || !$descripcion || !$precio || !$stock || !$categoria_id || !$imagen['name']) {
                    header("Location: ../crear_producto.php?mensaje=faltan_campos");
                    exit();
                }

                // Validar tipo de imagen
                $tipos_validos = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($imagen['type'], $tipos_validos)) {
                    header("Location: ../crear_producto.php?mensaje=tipo_no_valido");
                    exit();
                }

                // Crear carpeta si no existe
                $directorio = dirname(__DIR__) . "/uploads/productos/";
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                // Subir imagen
                $nombre_imagen = uniqid() . "_" . basename($imagen['name']);
                $ruta_absoluta = $directorio . $nombre_imagen;

                if (!move_uploaded_file($imagen['tmp_name'], $ruta_absoluta)) {
                    header("Location: ../crear_producto.php?mensaje=fallo_subida");
                    exit();
                }

                // Guardar en la base de datos
                $producto = new Producto();
                $fecha = date('Y-m-d');
                $guardado = $producto->crear(
                    $categoria_id,
                    $nombre,
                    $descripcion,
                    $precio,
                    $stock,
                    $oferta,
                    $fecha,
                    $nombre_imagen // Solo el nombre, no la ruta
                );

                if ($guardado) {
                    header("Location: ../crear_producto.php?mensaje=ok");
                } else {
                    header("Location: ../crear_producto.php?mensaje=error_bd");
                }
                exit();
            }
            break;

        default:
            echo "Acción no reconocida.";
            break;
    }
} else {
    echo "No se especificó ninguna acción.";
}
