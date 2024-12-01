<?php
session_start(); // Inicia la sesión

$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto
$dbname = "mexico"; // Nombre de la base de datos
$port = 3307; // Puerto de MySQL

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $nombre = $_POST['nombre'];
    $contra = $_POST['contra'];
    $recordar = isset($_POST['recordar']); // Verifica si la casilla "recordar" está marcada
    
    // Verifica usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND contra = '$contra'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si el usuario es encontrado

        // Si la opción "recordar" está marcada, creamos una cookie que dure 30 días
        if ($recordar) {
            // Genera un token único para la cookie
            $cookie_value = md5($nombre . time());
            setcookie("usuario_recuerdo", $cookie_value, time() + (30 * 24 * 60 * 60), "/"); // Cookie por 30 días
        }

        // Guarda la información del usuario en la sesión
        $_SESSION['usuario'] = $nombre;
        
        // Redirige al usuario a la página principal (perfil)
        header("Location: /paginaViajesOriginal/perfil.html");
        exit(); // Siempre usar exit después de header
    } else {
        echo "Nombre o contraseña incorrectos.";
    }
}

$conn->close();
?>


