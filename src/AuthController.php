<?php
require_once("../config/bd.php");

if ($_GET['action'] === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $tipo_usuario = 2; 

    try {
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, correo, clave, tipo_usuario) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $correo, $clave, $tipo_usuario]);

        header("Location: ../views/auth/login.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al registrar usuario: " . $e->getMessage();
    }
}

?>