<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mexico";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $contra = $conn->real_escape_string($_POST['contra']);

    $checkSql = "SELECT id FROM usuarios WHERE nombre = '$nombre' OR correo = '$correo'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        header("Location: /paginaViajesOriginal/registro.html?error=1");
        exit();
    } else {
        $sql = "INSERT INTO usuarios (nombre, correo, contra) VALUES ('$nombre', '$correo', '$contra')";
        if ($conn->query($sql) === TRUE) {
            header("Location: /paginaViajesOriginal/login.html?success=1");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>
