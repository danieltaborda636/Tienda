<?php
class ControladorProductos {

    public function create() {
        include 'views/product/create.php';
    }

    public function store() {
        require_once __DIR__ . '/../config/database.php';
        require_once __DIR__ . '/../models/producto.php';   

        if (
            isset($_POST['nombre']) &&
            isset($_POST['descripcion-producto']) &&
            isset($_POST['precio']) &&
            isset($_POST['stock']) &&
            isset($_POST['oferta']) &&
            isset($_POST['categoria_id']) &&
            isset($_FILES['img'])
        ) {
            //formulario
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion-producto'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $oferta = $_POST['oferta'];
            $categoria_id = $_POST['categoria_id'];
            $fecha = date("Y-m-d");

            // Imagen
            $nombreDeImagen = $_FILES['img']['name'];
            $imagenTemporal = $_FILES['img']['tmp_name'];
            $rutaDestino = 'archivos-subidos/productos/' . $nombreDeImagen;

            // aca verifico si va la imagen 
            $tipoArchivo = mime_content_type($imagenTemporal);
            if (strpos($tipoArchivo, 'image') === false) {
                echo "La imagen no es válida.";
                return;
            }

            // Se suve la imagen
            if (move_uploaded_file($imagenTemporal, $rutaDestino)) {
                $conexion = Database::connect();

                $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conexion, $sql);
                mysqli_stmt_bind_param($stmt, "isssdsss", $categoria_id, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $nombreDeImagen);

                if ($stmt->execute()) {
                    echo "se guando correctamente.";
                } else {
                    echo "Error al guardar.";
                }

            } else {
                echo "No se subio la imagen.";
            }

        } else {
            echo "Todos los campos se deben llenar obligatoriamente.";
        }
    }
}

