<?php
//Controlador de sidebar según el tipo de usuario
if (isset($_SESSION['tipo_usuario_id'])) {
    $tipo_usuario_id = $_SESSION['tipo_usuario_id'];

    if ($tipo_usuario_id == 1) {
        include 'sidebars/admin_sidebar.php';
    } elseif ($tipo_usuario_id == 2) {
        include 'sidebars/user_sidebar.php';
    } elseif ($tipo_usuario_id == 3) {
        include 'sidebars/guest_sidebar.php';
    } else {
        // Si el tipo de usuario no coincide con ninguno, puedes redirigir o mostrar un mensaje de error.
        echo "Tipo de usuario no reconocido.";
    }
    
}

?>