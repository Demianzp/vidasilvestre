<?php
// Conexión a la base de datos
require '../../conn/connection.php';

// Obtener los datos del formulario
$alumno_id = isset($_POST['alumno_id']) ? $_POST['alumno_id'] : null;
$materia_id = isset($_POST['materia_id']) ? $_POST['materia_id'] : null;
$ciclo_lectivo = isset($_POST['ciclo_lectivo']) ? $_POST['ciclo_lectivo'] : null;

if ($alumno_id && $materia_id && $ciclo_lectivo) {
    // Verificar si ya existe un registro para este alumno y materia en el ciclo lectivo actual
    $sql_check = "SELECT * FROM alumno_materia WHERE id_persona = $alumno_id AND id_materia = $materia_id AND id_ciclo = $ciclo_lectivo";
    $result_check = $conexion->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Actualizar el estado a "Inscripto"
        $sql_update = "UPDATE alumno_materia SET estado = 'Inscripto' WHERE id_persona = $alumno_id AND id_materia = $materia_id AND id_ciclo = $ciclo_lectivo";
        if ($conexion->query($sql_update) === TRUE) {
            echo "Inscripción actualizada.";
        } else {
            echo "Error: " . $sql_update . "<br>" . $conexion->error;
        }
    } else {
        // Insertar un nuevo registro
        $sql_insert = "INSERT INTO alumno_materia (id_persona, id_materia, id_ciclo, estado) VALUES ($alumno_id, $materia_id, $ciclo_lectivo, 'Inscripto')";
        if ($conexion->query($sql_insert) === TRUE) {
            echo "Inscripción exitosa.";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conexion->error;
        }
    }
} else {
    echo "Datos insuficientes.";
}

$conexion->close();

// Redirigir de vuelta a la página del estado del alumno
header("Location: alumno_estado.php?id=$alumno_id");
exit;
?>
