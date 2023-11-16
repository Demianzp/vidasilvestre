<?php
// procesar_inscripcion2.php
// Asegúrate de tener la conexión a la base de datos activa aquí
require 'conn/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se han seleccionado alumnos
    if (isset($_POST['alumnos']) && is_array($_POST['alumnos']) && !empty($_POST['alumnos'])) {
        // Verificar si se ha seleccionado materia y ciclo lectivo
        if (isset($_POST['materia']) && isset($_POST['ciclo'])) {
            // Obtenemos la materia y el ciclo lectivo seleccionados
            $materiaId = $_POST['materia'];
            $cicloId = $_POST['ciclo'];

            // Recorre los IDs de los alumnos seleccionados
            foreach ($_POST['alumnos'] as $alumnoId) {
                // Realiza las operaciones de inscripción para cada alumno
                // Insertar en la tabla estadoalumno
                $query = "INSERT INTO estadoalumno (id_persona, id_materia, id_ciclo) VALUES (:id_persona, :id_materia, :id_ciclo)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id_persona', $alumnoId, PDO::PARAM_INT);
                $stmt->bindParam(':id_materia', $materiaId, PDO::PARAM_INT);
                $stmt->bindParam(':id_ciclo', $cicloId, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    // Éxito al insertar, puedes realizar otras operaciones si es necesario
                } else {
                    // Error al insertar
                    // Manejar el error según tus necesidades
                    echo "Error al insertar en la base de datos.";
                    exit();
                }
            }

            // Redirige a la página de alumnos con un mensaje de éxito
            header("Location: listadoalumnos.view.php?mensaje=Inscripción procesada correctamente");
            exit();
        } else {
            // No se seleccionaron materia y ciclo lectivo, redirige con un mensaje de error
            header("Location: listadoalumnos.view.php?error=Debes seleccionar una materia y un ciclo lectivo para la inscripción");
            exit();
        }
    }
} else {
    // Si no es una solicitud POST, redirige a la página de alumnos
    header("Location: listadoalumnos.view.php");
    exit();
}
?>
