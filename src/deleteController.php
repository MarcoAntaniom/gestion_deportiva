<?php
require_once("../config/bd.php");

// Verifica si se ha pasado un id por GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta el equipo a eliminar
    $query = "SELECT * FROM equipos WHERE id = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $equipo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$equipo) {
        // Si no se encuentra el equipo, mostrar error con SweetAlert
        header('Location: ../views/admin/listados/listado_equipos_admin.php?error=equipo_no_encontrado');
        exit();
    }

    // Obtener el nombre de la división según el division_id
    $queryDivision = "SELECT division FROM divisiones WHERE id = :division_id";
    $stmtDivision = $conexion->prepare($queryDivision);
    $stmtDivision->bindParam(':division_id', $equipo['division_id']);
    $stmtDivision->execute();
    $division = $stmtDivision->fetch(PDO::FETCH_ASSOC)['division'];

    // Elimina el escudo desde la carpeta correspondiente a su división
    $escudo_path = "../views/img/escudos/" . $division . "/" . $equipo['escudo'];
    if (file_exists($escudo_path)) {
        unlink($escudo_path);
    }

    // Elimina el equipo de la base de datos
    $query = "DELETE FROM equipos WHERE id = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirigir con un mensaje de éxito usando SweetAlert
    header('Location: ../views/admin/listados/listado_equipos_admin.php?success=equipo_eliminado');
    exit();
} else {
    // Si no se pasa el ID, mostrar error con SweetAlert
    header('Location: ../views/admin/listados/listado_equipos_admin.php?error=id_no_especificado');
    exit();
}