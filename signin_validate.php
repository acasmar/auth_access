<?php

require_once 'pdo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $confirmed_password = trim(htmlspecialchars($_POST['confirmed_password']));

    // Validación de inputs
    if ($password !== $confirmed_password) {
        header("Location: sign.phtml?error=2");
        exit;
    }

    if (strlen($password) > 32 || strlen($password) < 10) {
        header("Location: sign.phtml?error=4");
        exit;
    }

    if (strlen($confirmed_password) > 32 || strlen($confirmed_password) < 10) {
        header("Location: sign.phtml?error=4");
        exit;
    }

    if (strlen($name) > 16 || strlen($name) < 6) {
        header("Location: sign.phtml?error=1");
        exit;
    }

    // Validación de datos (por ejemplo, asegurarse de que los campos no estén vacíos)
    if (empty($email) || empty($name) || empty($password) || empty($confirmed_password)) {
        header("Location: sign.phtml?error=3");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: sign.phtml?error=5");
        exit;
    }

    // Verificar si el usuario ya está registrado
    $query = "SELECT account_id FROM accounts WHERE account_name = ? OR account_email = ?";
    $values = [
        ':account_name' => $name,
        ':account_email' => $email,
    ];

    try {
        // Preparar y ejecutar la consulta
        $res = $pdo->prepare($query);
        $res->execute([$name, $email]);

        // Obtenemos el rol
        

        // Verificar si ya existe el nombre de usuario
        if ($res->rowCount() > 0) {
            header("Location: sign.phtml?error=7");
            exit;
        }
    
    } catch (PDOException $e) {
        echo 'Error en la verificación de la existencia del usuario: ' . $e->getMessage();
        exit;
    }

    // Si la validación es exitosa, se redirige al siguiente paso para la inserción
    // Usamos una variable de sesión para pasar los datos al siguiente paso
    session_start();
    $_SESSION['user_username'] = $name;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_password'] = $password;
    $_SESSION['user_role'] = $role;


    // Redirigir al archivo de inserción
    header("Location: insert_user.php");
    exit;
}

