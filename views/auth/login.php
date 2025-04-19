<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST" action="../../src/loginController.php">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required><br><br>

        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>