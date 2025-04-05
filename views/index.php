<?php
session_start();

// Verifica que no se haya enviado salida antes
if (headers_sent()) {
    exit("Error: Ya se enviaron encabezados.");
}

// Verifica si hay sesión activa
if (!isset($_SESSION['tipo_usuario_id'])) {
    // Si no hay sesión activa, redirige a la página de inicio de sesión
    header("Location: auth/login.php");
    exit();
}

$tipo_usuario_id = $_SESSION['tipo_usuario_id'];

switch ($tipo_usuario_id) {
    case 1:
        header("Location: admin/index.php");
        exit();
    case 2:
        header("Location: entrenador/index.php");
        exit();
    case 3:
        header("Location: administrativo/index.php");
        exit();
    default:
        header("Location: auth/login.php");
        exit();
}

?>