<?php
require_once("../config/bd.php");

// Verifica si se ha pasado un id por GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta el usuario a eliminar
    $query = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id); // Se agregó ":" que faltaba
    $stmt->execute();
    $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$usuario) {
        // Si no se encuentra el usuario, mostrar error
        echo "Usuario no encontrado.";
        exit(); // Faltaba el punto y coma aquí
    }

    // Elimina el usuario de la base de datos
    $query = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirigir al listado de usuarios con un mensaje de éxito
    echo "<script>
        alert('El usuario ha sido eliminado correctamente.');
        window.location.href = '../views/listados/listado_usuarios.php';
        </script>";
    exit;
} else {
    echo "ID no especificado";
    exit;
}