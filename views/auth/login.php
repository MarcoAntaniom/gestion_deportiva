<?php
session_start();
require_once("../../config/bd.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'] ?? null;
    $contrasena = $_POST['contrasena'] ?? null;

    // Verificar si se han ingresado los datos
    if (!$correo || !$contrasena) {
        echo "Por favor, complete todos los campos.";
        exit;
    }

    try {
        // Realizar consulta a la base de datos
        $query = "
        SELECT u.*, tu.id AS tipo_usuario_id, tu.nombre AS tipo_usuario_nombre FROM
        usuarios u
        LEFT JOIN tipo_usuario tu ON u.tipo_usuario = tu.id
        WHERE u.correo = :correo";

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();

        // Verificar si se encontró el usuario
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            if ($contrasena === $usuario['clave']) { 
                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['tipo_usuario_id'] = $usuario['tipo_usuario_id'];
                $_SESSION['correo'] = $usuario['correo'];
                $_SESSION['logueado'] = true;

                // Redirigir según el tipo de usuario
                if ($_SESSION['tipo_usuario_id'] == 1) {
                    header("Location: ../admin/index.php");
                    exit;
                } elseif ($_SESSION['tipo_usuario_id'] == 2) {
                    header("Location: ../entrenador/index.php");
                    exit;
                } elseif ($_SESSION['tipo_usuario_id'] == 3) {
                    header("Location: ../atleta/index.php");
                    exit;
                } else {
                    echo "Tipo de usuario no reconocido.";
                }
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Correo no registrado.";
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST" action="login.php">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="contrasena" id="password" required><br><br>

        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>