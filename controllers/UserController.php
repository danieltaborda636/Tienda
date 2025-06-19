<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $user = new user();
    $usuario = $user->login($email, $password);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ../index.php?view=login&login=error");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $Nombre    = trim($_POST["Nombre"]);
    $Apellidos = trim($_POST["Apellidos"]);
    $email     = trim($_POST["email"]);
    $password  = trim($_POST["password"]);

    if (empty($Nombre) || empty($Apellidos) || empty($email) || empty($password)) {
        header("Location: ../index.php?view=register&registro=campos_invalidos");
        exit;
    } else {
        $user = new user();
        $registrado = $user->registrar($Nombre, $Apellidos, $email, $password);

        if ($registrado === true) {
            header("Location: ../index.php?view=register&registro=exito");
            exit;
        } elseif ($registrado === "duplicado") {
            header("Location: ../index.php?view=register&registro=duplicado");
            exit;
        } else {
            header("Location: ../index.php?view=register&registro=error");
            exit;
        }

    }
}
?>
