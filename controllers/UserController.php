<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';

// INICIAR SESIÓN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $user = new User(); // Asegúrate de que la clase esté con mayúscula: User
    $usuario = $user->login($email, $password);

    if ($usuario) {
        // Guardar todos los datos importantes del usuario, incluyendo el rol
        $_SESSION['usuario'] = [
            'id'        => $usuario['id'],
            'nombre'    => $usuario['nombre'],
            'apellidos' => $usuario['apellidos'],
            'email'     => $usuario['email'],
            'rol'       => $usuario['rol'] // 🔹 Agregado el rol aquí
        ];
        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ./../views/user/login.php?view=login&login=error");
        exit;
    }
}

// REGISTRO DE USUARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $Nombre    = trim($_POST["Nombre"]);
    $Apellidos = trim($_POST["Apellidos"]);
    $email     = trim($_POST["email"]);
    $password  = trim($_POST["password"]);

    if (empty($Nombre) || empty($Apellidos) || empty($email) || empty($password)) {
        header("Location: ./../views/user/registro.php?view=register&registro=campos_invalidos");
        exit;
    } else {
        $user = new User();
        $registrado = $user->registrar($Nombre, $Apellidos, $email, $password);

        if ($registrado === true) {
            header("Location: ./../views/user/registro.php?view=register&registro=exito");
            exit;
        } elseif ($registrado === "duplicado") {
            header("Location: ./../views/user/registro.php?view=register&registro=duplicado");
            exit;
        } else {
            header("Location: ./../views/user/registro.php?view=register&registro=error");
            exit;
        }
    }
}
