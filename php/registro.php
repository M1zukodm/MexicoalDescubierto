<?php
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

// Recibe datos del formulario
$nombre = $_POST['nombre'];  
$correo = $_POST['correo'];   // Asegúrate de que el campo de correo se llama 'correo'
$contra = $_POST['contra'];   // Asegúrate de que el campo de contraseña se llama 'contra'

// Inserta datos en la base de datos
$sql = "INSERT INTO usuarios (nombre, correo, contra) VALUES ('$nombre', '$correo', '$contra')";

if ($conn->query($sql) === TRUE) {
    echo "¡Registro exitoso!";
    header("Location: /paginaViajesOriginal/perfil.html"); // Redirige a perfil.html
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
