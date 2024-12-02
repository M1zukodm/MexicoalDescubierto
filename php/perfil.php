<?php
session_start(); // Inicia la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /paginaViajesOriginal/login.html");
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto
$dbname = "mexico"; // Nombre de tu base de datos
$port = 3307; // Puerto configurado de MySQL

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del usuario basado en su ID
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nombre, correo, contra FROM usuarios WHERE id = '$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Usuario no encontrado.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #ADD8E6;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .navbar {
            width: 100%;
            background-color: #ECE3CE;
            padding: 15px;
            text-align: center;
            border-bottom: 2px solid #ccc;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            background-color: #ECE3CE;
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        .btn.green {
            background-color: #28a745;
        }

        .btn.green:hover {
            background-color: #218838;
        }

        .btn.red {
            background-color: #dc3545;
        }

        .btn.red:hover {
            background-color: #c82333;
        }

        .btn.blue {
            background-color: #007bff;
        }

        .btn.blue:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Perfil de Usuario</h1>
    </div>
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?>!</h2>
        <form action="editar_perfil.php" method="POST">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>

            <label for="contra">Nueva Contraseña</label>
            <input type="password" id="contra" name="contra" placeholder="Dejar vacío para mantener la actual">

            <button class="btn green" type="submit">Guardar Cambios</button>
        </form>

        <a href="logout.php">
            <button class="btn red">Cerrar Sesión</button>
        </a>

        <a href="../index.html">
            <button class="btn blue">Volver a la Página Principal</button>
        </a>
    </div>
</body>
</html>
