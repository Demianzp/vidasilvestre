<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Materias y Correlativas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Tabla de Materias y Correlativas</h1>
    <?php
    // Conexión a la base de datos (ajusta los detalles de conexión)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "vida_silvestre";

    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL para obtener nombres de materias y sus correlativas
    $sql = "SELECT m.id_materia, m.nombre AS 'Materia', c.id_correlativa, c.id_materia AS 'Correlativa'
            FROM materia m
            LEFT JOIN correlativa c ON m.id_materia = c.id_materia";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID Materia</th><th>Materia</th><th>ID Correlativa</th><th>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id_materia"] . "</td><td>" . $row["Materia"] . "</td><td>" . $row["id_correlativa"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron registros.";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
