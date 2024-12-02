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
    $contra = $conn->real_escape_string($_POST['contra']);

    $sql = "SELECT id, contra FROM usuarios WHERE nombre = '$nombre'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['contra'] === $contra) {
            $_SESSION['usuario_id'] = $user['id'];
            header("Location: /paginaViajesOriginal/php/perfil.php");
            exit();
        } else {
            header("Location: /paginaViajesOriginal/login.html?error=1");
            exit();
        }
    } else {
        header("Location: /paginaViajesOriginal/login.html?error=1");
        exit();
    }
}
$conn->close();
?>
