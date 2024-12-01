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

// Obtener registros de la base de datos
$sql = "SELECT title, photo, name, comment FROM viajes";
$result = $conn->query($sql);

// Generar HTML para los registros
$html = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Verificar si la ruta de la foto está vacía o no
        $photo = !empty($row['photo']) ? $row['photo'] : "recursos/default.jpg";
        
        // Crear la ruta completa para la imagen
        $photoPath = "http://localhost:8081/paginaViajesOriginal/" . $photo;

        $html .= "
            <div class='col-md-4 mb-4'>
                <div class='card'>
                    <!-- Modificar la ruta de la imagen -->
                    <img src='$photoPath' class='card-img-top' alt='Foto de viaje'>
                    <div class='card-body'>
                        <h5 class='card-title'>" . htmlspecialchars($row['title']) . "</h5>
                        <p class='card-text'><strong>Nombre:</strong> " . htmlspecialchars($row['name']) . "</p>
                        <p class='card-text'>" . htmlspecialchars($row['comment']) . "</p>
                    </div>
                </div>
            </div>";
    }
} else {
    $html = "<p>No hay comentarios aún. ¡Sé el primero en compartir tu experiencia!</p>";
}

// Cerrar la conexión
$conn->close();

// Mostrar el HTML generado
echo $html;
?>

