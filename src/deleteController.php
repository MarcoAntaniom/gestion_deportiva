<?php
require_once("../config/bd.php");

//Verifica si se ha pasado un id por GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta el equipo a eliminar
    $query = "SELECT * FROM equipos WHERE id = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $equipo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$equipo) {
        //Si no se encuentra el equipo, mostrar error
        echo "Equipo no encontrado.";
        exit();
    }

    //Elimina el escudo de la carpeta.
    $escudo_path = "../views/img/escudos/" . $equipo['escudo'];
    if (file_exists($escudo_path)) {
        unlink($escudo_path);
    }

    //Elimina el equipo de la base de datos
    $query = "DELETE FROM equipos WHERE id = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    //Redirigir al listado de equipos con un mensaje de éxito
    echo "<script>
        alert('El equipo ha sido eliminado correctamente.');
        window.location.href = '../views/admin/listados/listado_equipos_admin.php';
        </script>";
    exit;
} else {
    echo "ID no especificado";
    exit;
}