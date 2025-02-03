<?php
require_once 'pdo.php';

session_start();

// Datos de usuario para tests
$user =  $_SESSION['name'];

// No insertar, se inserta la password hasheada ($hash)
$pass = $_SESSION['password'];
$role = 'usuario';

// Hasheamos la password
// Opciones para la función password_hash()
$options = [
    'cost' => 12,
];

// Hash obtenida
$hash = password_hash($pass, PASSWORD_BCRYPT, $options);

// Query preparada
$query = 'INSERT INTO accounts (account_name, account_password, account_role) VALUES (:account_name, :account_password, :account_role)';
$values = [
    ':account_name' => $user,
    ':account_password' => $hash,
    ':account_role' => $role
];

// Ejecución
try {
    
    $res = $pdo->prepare($query);
    $res -> execute($values);

    echo 'Usuario insertado en base de datos';

} catch (PDOException $e) {
    echo 'Error en la inserción en la base de datos';
}