<?php
// Conexión a la base de datos
require '../../conn/connection.php';

// Obtener los datos del formulario
$alumno_id = isset($_POST['id_persona']) ? $_POST['id_persona'] : null;
$materia_id = isset($_POST['id_materia']) ? $_POST['id_materia'] : null;

if ($alumno_id && $materia_id) {
    // Verificar si ya existe un registro para este alumno y materia
    $sql_check = "SELECT * FROM alumno_materia  WHERE id_persona = $alumno_id AND id_materia = $materia_id";
    $result_check = $conexion->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Actualizar el estado a "Inscripto"
        $sql_update = "UPDATE alumno_materia SET estado = 'Inscripto' WHERE id_persona = $alumno_id AND id_materia = $materia_id";
        if ($conexion->query($sql_update) === TRUE) {
            echo "Inscripción actualizada.";
        } else {
            echo "Error: " . $sql_update . "<br>" . $conexion->error;
        }
    } else {
        // Insertar un nuevo registro
        $sql_insert = "INSERT INTO alumno_materia (id_persona, id_materia, estado) VALUES ($alumno_id, $materia_id, 'Inscripto')";
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
