<?php

//conexión a la base de datos
$host = 'localhost';
$dbname = 'gestion_deportiva';
$username = 'root';
$password = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

?>