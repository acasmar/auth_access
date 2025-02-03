<?php

require_once 'pdo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $name = htmlspecialchars($_POST['name']);
    $password = htmlspecialchars($_POST['password']);
    $confirmed_password = htmlspecialchars($_POST['confirmed_password']);

    // Validación de inputs
    if ($password !== $confirmed_password) {
        echo "Las contraseñas no coinciden. <a href='javascript:history.back()'>Intenta de nuevo</a>";
        exit;
    }

    if (strlen($password) > 32 || strlen($password) < 10) {
        echo "Por favor use una contraseña que tenga entre 10 y 32 caracteres.";
        exit;
    }

    if (strlen($name) > 16 || strlen($name) < 6) {
        echo "Por favor usa un nombre de usuario como máximo de 16 caracteres y mínimo 6 caracteres.";
        exit;
    }

    // Validación de datos (por ejemplo, asegurarse de que los campos no estén vacíos)
    if (empty($name) || empty($password) || empty($confirmed_password)) {
        echo "Por favor, complete todos los campos. <a href='javascript:history.back()'>Intenta de nuevo</a>";
        exit;
    }

    // Verificar si el usuario ya está registrado
    $query = "SELECT account_id FROM accounts WHERE account_name = ?";
    $values = [
        ':account_name' => $name,
    ];

    try {
        // Preparar y ejecutar la consulta
        $res = $pdo->prepare($query);
        $res->execute([$name]);

        // Verificar si ya existe el nombre de usuario
        if ($res->rowCount() > 0) {
            echo "Este nombre de usuario no está disponible para su uso. <a href='javascript:history.back()'>Intenta de nuevo</a>";
            exit;
        }
    
    } catch (PDOException $e) {
        echo 'Error en la verificación de la existencia del usuario: ' . $e->getMessage();
        exit;
    }

    // Si la validación es exitosa, se redirige al siguiente paso para la inserción
    // Usamos una variable de sesión para pasar los datos al siguiente paso
    session_start();
    $_SESSION['name'] = $name;
    $_SESSION['password'] = $password;


    // Redirigir al archivo de inserción
    header("Location: insert_user.php");
    exit;
}

