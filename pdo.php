<?php

require_once 'conection.php';

// Define el DSN
$dsn = 'mysql:host=' . HOST . ';dbname=' . DB;

try {
    // Crea la conexión con PDO
    $pdo = new PDO($dsn, USUARIODB, PASSWORD);
    // Configura atributos para manejar errores de manera adecuada
    
} catch (PDOException $e) {
    // Muestra un mensaje de error más claro
    echo $e;
    die();
}