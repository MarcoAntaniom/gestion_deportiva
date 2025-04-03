<?php

//Conexión a la base de datos
$host = 'localhost';
$dbname = 'gestion_educativa';
$usuario = 'root';
$pass = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

exit();
?>