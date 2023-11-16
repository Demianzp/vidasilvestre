<?php
// Verificar si se enviaron datos por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se seleccionó al menos una materia y un alumno
    if (!empty($_POST['id_materia']) && isset($_POST['id_persona'])) {
        // Conexión a la base de datos (reemplaza estos valores con los tuyos)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "vidasilvestre";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Definir el valor por defecto para id_ciclo (en este caso, 2)
        $id_ciclo = 2;

        // Recibir datos del formulario
        $id_personas = explode(",", $_POST['id_persona']);
        $id_materias = $_POST['id_materia'];

        // Procesar la inserción en la base de datos
        foreach ($id_personas as $id_persona) {
            foreach ($id_materias as $id_materia) {
                // Query de inserción en estadoalumno con id_ciclo por defecto
                $sql = "INSERT INTO estadoalumno (id_persona, id_materia, id_ciclo) VALUES ('$id_persona', '$id_materia', '$id_ciclo')";

                // Ejecutar la consulta
                if ($conn->query($sql) === TRUE) {
                    $mensaje = "Carga exitosa";
                    header("Location: seleccionar_alumnos.php?mensaje=" . urlencode($mensaje));
                    exit();
                } else {
                    $error = "Error: " . $conn->error;
                    header("Location: seleccionar_alumnos.php?error=" . urlencode($error));
                    exit();
                }
            }
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        $error = "Error: Debes seleccionar al menos una materia y un alumno.";
        header("Location: seleccionar_alumnos.php?error=" . urlencode($error));
        exit();
    }
} else {
    // Si alguien intenta acceder a este archivo directamente sin enviar datos por el formulario
    $error = "Acceso no permitido";
    header("Location: seleccionar_alumnos.php?error=" . urlencode($error));
    exit();
}
