<?php
session_start(); // Inicia la sesión

// Eliminar la cookie de "recordar sesión"
if (isset($_COOKIE['usuario_recuerdo'])) {
    setcookie('usuario_recuerdo', '', time() - 3600, '/'); // Expiramos la cookie
}

// Cerrar la sesión
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirigir al login
header("Location: ../login.html");
exit();
?>
