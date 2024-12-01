<?php
session_start(); // Inicia la sesión

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $nombre = $_POST['nombre'];
    $contra = $_POST['contra'];

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

    // Consulta de usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND contra = '$contra'";
    $result = $conn->query($sql);

    // Si el usuario existe, iniciamos la sesión
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $_SESSION['usuario_id'] = $usuario['id']; // Guardamos el ID del usuario en la sesión
        $_SESSION['usuario_nombre'] = $usuario['nombre']; // Guardamos el nombre del usuario en la sesión

        // Redirigir al perfil
        header("Location: perfil.php");
        exit(); // Asegurarse de salir después de la redirección
    } else {
        echo "Nombre o contraseña incorrectos.";
    }

    // Cerrar la conexión
    $conn->close();
}
?>
