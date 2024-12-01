<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto
$dbname = "mexico"; // Nombre de tu base de datos
$port = 3307; // Puerto configurado de MySQL

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$title = $_POST['title'];
$name = $_POST['name'];
$comment = $_POST['comment'];

// Manejar la subida de la foto
$photo = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $photoName = basename($_FILES['photo']['name']);
    $targetDir = "../uploads/"; // Asegúrate de que la carpeta 'uploads' esté en la raíz

    // Crear la carpeta si no existe
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Definir la ruta completa del archivo
    $targetFile = $targetDir . $photoName;

    // Intentar mover el archivo subido
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
        $photo = "uploads/" . $photoName; // Guardar la ruta relativa en la base de datos
    } else {
        // Redirigir con error si falla
        header("Location: ../index.html?status=error");
        exit;
    }
}

// Insertar datos en la base de datos
$sql = "INSERT INTO viajes (title, photo, name, comment) VALUES ('$title', '$photo', '$name', '$comment')";

if ($conn->query($sql) === TRUE) {
    // Redirigir con éxito
    header("Location: ../viajes.html");
} else {
    // Redirigir con error
    header("Location: ../viajes.html");
}

$conn->close();
?>

