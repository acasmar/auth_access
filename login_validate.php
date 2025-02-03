<?php

require_once 'pdo.php'; // Asegúrate de tener la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $name = htmlspecialchars($_POST['name']);
    $password = htmlspecialchars($_POST['password']);

    // Validación de datos (por ejemplo, asegurarse de que los campos no estén vacíos)
    if (empty($name) || empty($password)) {
        echo "Por favor, complete todos los campos. <a href='javascript:history.back()'>Intenta de nuevo</a>";
        exit;
    }

    // Verificar si el usuario existe
    $query = "SELECT account_id, account_name, account_password FROM accounts WHERE account_name = ?";
    $values = [
        ':account_name' => $name,
    ];

    try {
        // Preparar y ejecutar la consulta
        $res = $pdo->prepare($query);
        $res->execute([$name]);

        // Verificar si el usuario existe
        if ($res->rowCount() == 0) {
            echo "Usuario o contraseña incorrectos. <a href='javascript:history.back()'>Intenta de nuevo</a>";
            exit;
        }

        // Obtener los resultados
        $user = $res->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña
        if (!password_verify($password, $user['account_password'])) {
            echo "Usuario o contraseña incorrectos. <a href='javascript:history.back()'>Intenta de nuevo</a>";
            exit;
        }

        // Si las credenciales son correctas, iniciar sesión
        session_start();
        $_SESSION['user_id'] = $user['account_id'];
        $_SESSION['username'] = $user['account_name'];

        // Redirigir al usuario a la página principal o dashboard
        header("Location: index.phtml");
        exit;

    } catch (PDOException $e) {
        echo 'Error en la verificación del login: ' . $e->getMessage();
        exit;
    }
}
?>