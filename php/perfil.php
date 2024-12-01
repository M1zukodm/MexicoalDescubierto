<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redirigir a la página de login si no está autenticado
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

// Consultar datos del usuario, basándonos en el ID guardado en la sesión
$usuario_id = $_SESSION['usuario_id']; // Asumimos que el ID del usuario está guardado en la sesión
$sql = "SELECT nombre, correo, contraseña FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

// Verificar si se encontraron los datos del usuario
if (!$usuario) {
    die("Error: No se encontraron datos del usuario.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="recursos/personalogo.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Perfil de Usuario</title>
    <style>
        /* Estilos existentes */
        body {
            font-family: Arial, sans-serif;
            background-color: #ADD8E6;
            margin: 0;
            padding: 20px;
            align-items: center;
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
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a class="navbar-brand" href="index.html">
            <img src="recursos/logo.png" alt="logo" title="México al Descubierto" style="height: 40px;">
        </a>
        <h1 style="font-family: 'Playfair Display', serif; color: black; font-size: 50px; margin: 0; flex-grow: 1; text-align: center;">
            <i class="fa-solid fa-user"></i> Tu perfil
        </h1>
    </div>
    
    <div class="container">
        <h2>Perfil de Usuario</h2>
        <form action="actualizar_perfil.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" value="<?php echo htmlspecialchars($usuario['contraseña']); ?>" required>

            <button type="submit" class="btn">Guardar Cambios</button>
        </form>
    </div>

</body>
</html>

<?php
$conn->close(); // Cerrar la conexión con la base de datos
?>
