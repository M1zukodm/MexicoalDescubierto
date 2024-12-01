<?php
session_start(); // Inicia la sesión

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];  // Asegúrate de que el campo de correo se llama 'correo'
    $contra = $_POST['contra'];  // Asegúrate de que el campo de contraseña se llama 'contra'

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

    // Verificar si el nombre de usuario ya está registrado
    $sql_check = "SELECT * FROM usuarios WHERE nombre = '$nombre' OR correo = '$correo'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Si el nombre o correo ya existe, muestra un mensaje
        echo "El nombre de usuario o correo ya está registrado. Por favor, elige otro.";
    } else {
        // Si el nombre de usuario no está registrado, inserta el nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, correo, contra) VALUES ('$nombre', '$correo', '$contra')";

        if ($conn->query($sql) === TRUE) {
            // Registra el usuario en la sesión después de registrarlo
            $_SESSION['usuario_nombre'] = $nombre; // Guardamos el nombre del usuario en la sesión
            $_SESSION['usuario_correo'] = $correo; // Guardamos el correo del usuario en la sesión

            // Redirige al perfil
            echo "¡Registro exitoso!";
            header("Location: perfil.php"); // Redirige a perfil.php
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Cerrar la conexión
    $conn->close();
}
?>
