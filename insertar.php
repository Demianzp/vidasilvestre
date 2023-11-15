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

        // Recibir datos del formulario
        $id_personas = explode(",", $_POST['id_persona']);
        $id_materias = $_POST['id_materia'];

        // Verificar el botón presionado
        $accion = $_POST['accion'];

        // Procesar la acción correspondiente
        switch ($accion) {
            case 'Inscribir':
                // Tu lógica para la inscripción
                break;

            case 'Cancelar':
                // Tu lógica para la cancelación
                // Puedes cambiar el estado de la inscripción en tu base de datos
                break;

            default:
                // Acción no reconocida
                break;
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
?>

