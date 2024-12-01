<?php
session_start(); // Inicia la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html"); // Si no está autenticado, redirige al login
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto
$dbname = "mexico"; // Nombre de tu base de datos
$port = 3307; // Puerto configurado de MySQL

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del usuario desde la sesión
$usuario_id = $_SESSION['usuario_id'];

// Verificar si se ha enviado el formulario con los nuevos datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contra = $_POST['contra']; // Nueva contraseña

    // Si se proporciona una nueva contraseña, la actualizamos
    if (!empty($contra)) {
        // No ciframos la contraseña
        $sql = "UPDATE usuarios SET nombre = '$nombre', correo = '$correo', contra = '$contra' WHERE id = '$usuario_id'";
    } else {
        // Si no se proporciona una nueva contraseña, solo actualizamos el nombre y correo
        $sql = "UPDATE usuarios SET nombre = '$nombre', correo = '$correo' WHERE id = '$usuario_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Perfil actualizado correctamente.";
    } else {
        echo "Error al actualizar perfil: " . $conn->error;
    }

    // Redirigir al perfil después de la actualización
    header("Location: perfil.php");
    exit();
}

// Cerrar la conexión
$conn->close();
?>
