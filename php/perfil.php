<?php
session_start(); // Inicia la sesión

// Verificar si el usuario está autenticado (si no tiene la sesión activa, lo redirigimos al login)
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

// Obtener los datos del usuario (basándonos en el ID guardado en la sesión)
$usuario_id = $_SESSION['usuario_id']; // Obtener el ID de usuario de la sesión
$sql = "SELECT nombre, correo, contra FROM usuarios WHERE id = '$usuario_id'";
$result = $conn->query($sql);

// Mostrar los datos del usuario
if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Usuario no encontrado.";
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <style>
        /* Estilos para el diseño básico */
        body {
            font-family: Arial, sans-serif;
            background-color: #ADD8E6;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #ECE3CE;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 1460px;
            text-align: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            color: black;
            font-size: 50px;
            margin: 0;
            text-align: center;
        }
        .container {
            text-align: center;
            margin-top: 30px;
            background-color: #ECE3CE;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 200px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #218838;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Perfil de Usuario</h1>
    </div>
    <div class="container">
        <h2>¡Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?>!</h2>
        
        <form action="editar_perfil.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br><br>
            
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required><br><br>

            <label for="contra">Nueva Contraseña:</label>
            <input type="password" id="contra" name="contra" placeholder="Dejar vacío si no desea cambiarla"><br><br>
            
            <button class="btn" type="submit">Guardar Cambios</button>
        </form>
        
        <p><a href="php/logout.php" class="btn" style="background-color: #dc3545;">Cerrar sesión</a></p>

        <a href="../index.html">
            <button class="btn">Volver a la Página Principal</button>
        </a>
    </div>
</body>
</html>
