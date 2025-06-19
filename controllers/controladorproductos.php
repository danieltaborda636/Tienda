<?php
class ControladorProductos {

    public function create() {
        include 'views/user/create.php';
    }

    public function store() {
        require_once __DIR__ . '/../config/database.php';
        require_once __DIR__ . '/../models/producto.php';

        if (
            isset($_POST['nombre']) &&
            isset($_POST['descripcion_producto']) &&
            isset($_POST['precio']) &&
            isset($_POST['stock']) &&
            isset($_POST['oferta']) &&
            isset($_POST['categoria_id']) &&
            isset($_FILES['img'])
        ) {
            // Sanitizar entradas
            $nombre = htmlspecialchars($_POST['nombre']);
            $descripcion = htmlspecialchars($_POST['descripcion_producto']);
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $oferta = $_POST['oferta'];
            $categoria_id = $_POST['categoria_id'];
            $fecha = date("Y-m-d");

            // Validar archivo de imagen
            if ($_FILES['img']['error'] !== UPLOAD_ERR_OK) {
                header("Location: index.php?controller=productos&action=create&mensaje=error_imagen");
                exit;
            }

            $nombreDeImagen = $_FILES['img']['name'];
            $imagenTemporal = $_FILES['img']['tmp_name'];
            $tipoArchivo = mime_content_type($imagenTemporal);

            $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($tipoArchivo, $permitidos)) {
                header("Location: index.php?controller=productos&action=create&mensaje=tipo_no_valido");
                exit;
            }

            // Crear carpeta si no existe
            $rutaCarpeta = 'archivos-subidos/productos/';
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta, 0777, true);
            }

            $rutaDestino = $rutaCarpeta . $nombreDeImagen;

            // Subir imagen
            if (move_uploaded_file($imagenTemporal, $rutaDestino)) {
                $conexion = Database::connect();

                $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conexion, $sql);
                mysqli_stmt_bind_param($stmt, "isssdsss", $categoria_id, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $nombreDeImagen);

             if ($stmt->execute()) {
            header("Location: index.php?view=create&mensaje=ok");
            exit;
            } else {
                header("Location: index.php?view=create&mensaje=error_bd");
                exit;
            }

            }  else {
                    header("Location: index.php?view=create&mensaje=fallo_subida");
                    exit;
                }

        } else {
            header("Location: index.php?view=create&mensaje=faltan_campos");
            exit;
        }

    }
}
