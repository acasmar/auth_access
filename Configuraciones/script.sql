-- Crear base de datos
CREATE DATABASE IF NOT EXISTS `my_database`;

-- Usar la base de datos recién creada
USE `my_database`;

-- Crear tabla 'accounts'
CREATE TABLE IF NOT EXISTS `accounts` (
    `account_id` INT AUTO_INCREMENT PRIMARY KEY,
    `account_name` VARCHAR(50) NOT NULL,
    `account_email` VARCHAR(100) NOT NULL UNIQUE,
    `account_password` VARCHAR(255) NOT NULL,
    `account_role` VARCHAR(20) DEFAULT 'ROLE_USER' -- Establecer 'ROLE_USER' como valor predeterminado
);