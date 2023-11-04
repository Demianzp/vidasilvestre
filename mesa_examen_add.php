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

// Consulta para obtener las materias
$sql = "SELECT id_materia, nombre FROM materia";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("No hay materias disponibles en la base de datos.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Mesa de Examen</title>
</head>
<body>
    <h1>Agregar Mesa de Examen</h1>
    <form action="procesar_mesa.php" method="post">
        <label for="materia">Materia:</label>
        <select name="id_materia">
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id_materia'] . "'>" . $row['nombre'] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required>
        <br>
        <label for="hora">Hora:</label>
        <input type="time" name="hora" required>
        <br>
        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" required>
        <br>
        <input type="submit" value="Agregar Mesa">
    </form>
</body>
</html>
