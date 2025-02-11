<?php
require_once 'pdo.php';

session_start();

// Datos de usuario para tests.
$user =  $_SESSION['user_username'];
$email =  $_SESSION['user_email'];

// No insertar, se inserta la password hasheada ($pass_hashed).
$pass = $_SESSION['user_password'];

// El rol por defecto será ROLE_USER, equivalente a usuario genérico.
// El admin será 1
$role = 2;

// Hasheamos la password
// Opciones para la función password_hash()
$options = [
    'cost' => 12,
];

// Hash obtenida
$pass_hashed = password_hash($pass, PASSWORD_BCRYPT, $options);

// Query preparada
$query = 'INSERT INTO accounts (account_name, account_email, account_password, account_role) 
VALUES (:account_name, :account_email, :account_password, :account_role)';

$values = [
    ':account_name' => $user,
    ':account_email' => $email,
    ':account_password' => $pass_hashed,
    ':account_role' => $role
];

// Ejecución
try {
    
    $res = $pdo->prepare($query);
    $res -> execute($values);

    //header("Location: login.phtml?success=1");
    exit;

} catch (PDOException $e) {
    header("Location: sign.phtml?error=6");
    exit;
}