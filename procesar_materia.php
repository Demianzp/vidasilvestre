<?php
// Conexión a la base de datos (debes proporcionar tus propios datos de conexión)
$servername = "localhost";
$username = "root";
$password = "";
$database = "vida_silvestre";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Variables para mensajes
$mensaje = "";
$error = "";

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST["nombre"]);
    $descripcion = $conn->real_escape_string($_POST["descripcion"]);
    $horas = $conn->real_escape_string($_POST["horas"]);
    $año = $conn->real_escape_string($_POST["año"]);
    $num_resolucion = $conn->real_escape_string($_POST["num_resolucion"]);
    $plan_estudio = $conn->real_escape_string($_POST["plan_estudio"]);
    $tipo = $conn->real_escape_string($_POST["tipo"]);

    // Inserción de datos en la tabla 'materia' (usando sentencia preparada)
    $sql = "INSERT INTO materia (nombre, descripcion, horas, año, num_resolucion, plan_estudio, TIPO) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiss", $nombre, $descripcion, $horas, $año, $num_resolucion, $plan_estudio, $tipo);

    if ($stmt->execute()) {
        $mensaje = "Materia ingresada con éxito.";
    } else {
        $error = "Error al ingresar la materia: " . $stmt->error;
    }
    
    $stmt->close();
    
    // Redirigir a la página "registrar_materia.php" con los mensajes en la URL
    header("Location: registromateria.php?mensaje=" . urlencode($mensaje) . "&error=" . urlencode($error));
    exit();
     
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Materia</title>
    <!-- Agrega aquí tus enlaces a CSS u otras bibliotecas -->
</head>
<body>

</body>
</html>


