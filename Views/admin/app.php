<!DOCTYPE html>
<html>
<head>
    <title>Agregar Notas</title>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="alumno">Alumno:</label>
        <input type="text" name="alumno" required><br>

        <label for="materia">Materia:</label>
        <input type="text" name="materia" required><br>

        <?php
        $num_notas = 4; // Puedes cambiar este número para agregar más o menos notas
        for ($i = 1; $i <= $num_notas; $i++) {
            echo "<label for='nota{$i}'>Nota {$i}:</label>";
            echo "<input type='number' name='notas[]' step='0.01' required><br>";
        }
        ?>

        <input type="submit" name="submit" value="Agregar Notas">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "tu_usuario";
        $password = "tu_contraseña";
        $dbname = "vidasilvestre";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Obtener datos del formulario
        $alumno = $_POST['alumno'];
        $materia = $_POST['materia'];
        $notas = $_POST['notas'];

        // Preparar la consulta SQL
        $sql = "INSERT INTO nota (alumno, materia";
        $valores = "VALUES (?, ?";
        $tipos = "ss";
        $params = array($alumno, $materia);

        for ($i = 0; $i < count($notas); $i++) {
            $num = $i + 1;
            $sql .= ", nota{$num}";
            $valores .= ", ?";
            $tipos .= "d";
            $params[] = $notas[$i];
        }

        $sql .= ") " . $valores . ")";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($tipos, ...$params);
        
        if ($stmt->execute()) {
            echo "Notas agregadas correctamente";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>