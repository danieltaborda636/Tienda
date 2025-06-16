<?php
session_start();
require_once '../config/database.php'; // Ok

$mensaje = ""; 

if (!isset($_POST["enviar"])) {
    require_once '../views/user/register.php';
} else {
    $Nombre    = trim($_POST["Nombre"]);
    $Apellidos  = trim($_POST["Apellidos"]);
    $email     = trim($_POST["email"]);
    $password  = trim($_POST["password"]);

    if (empty($Nombre) || empty($Apellidos) || empty($email) || empty($password)) {
        $mensaje = "Por favor, completa todos los campos.";
    } else {
        require_once '../models/User.php';
        $user = new user();
        $registrado = $user->registrar($Nombre, $Apellidos, $email, $password);

        if ($registrado) {
            header("Location: ../index.php?controller=user&action=register&registro=exito");
            exit;
        } else {
            header("Location:register.php?controller=user&action=register&registro=error");
            exit;
        }

    }

    require_once '../views/user/register.php';
}
?>
