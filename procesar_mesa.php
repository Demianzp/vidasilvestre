<?php
// Conexión a la base de datos (reemplaza los valores con los de tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vida_silvestre";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Recopila los datos del formulario
$id_materia = $_POST['id_materia'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$tipo = $_POST['tipo'];

// Inserta la mesa de examen en la base de datos
$sql = "INSERT INTO mesa_examen (id_materia, fecha, hora, tipo) VALUES ('$id_materia', '$fecha', '$hora', '$tipo')";

if ($conn->query($sql) === TRUE) {
    echo "Mesa de examen agregada exitosamente.";
} else {
    echo "Error al agregar la mesa de examen: " . $conn->error;
}

// Cierra la conexión a la base de datos
$conn->close();
?>
