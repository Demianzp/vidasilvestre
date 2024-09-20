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

        <label for="nota1">Nota 1:</label>
        <input type="number" name="nota1" required><br>

        <label for="nota2">Nota 2:</label>
        <input type="number" name="nota2" required><br>

        <label for="nota3">Nota 3:</label>
        <input type="number" name="nota3" required><br>

        <label for="nota4">Nota 4:</label>
        <input type="number" name="nota4" required><br>

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
        $nota1 = $_POST['nota1'];
        $nota2 = $_POST['nota2'];
        $nota3 = $_POST['nota3'];
        $nota4 = $_POST['nota4'];

        // Preparar y ejecutar la consulta SQL
        $sql = "INSERT INTO nota (alumno, materia, nota1, nota2, nota3, nota4) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdddd", $alumno, $materia, $nota1, $nota2, $nota3, $nota4);
        
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
