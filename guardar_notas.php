<?php
require 'conn/connection.php';
var_dump($_GET);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_notas'])) {
    var_dump($_GET);
    // Iterar sobre las variables POST para obtener y guardar las notas
    foreach ($_POST as $key => $value) {
        // Verificar si la variable es una nota
        if (strpos($key, 'nota') !== false) {
            $id_persona = substr($key, strrpos($key, '_') + 1);

            // Actualizar la nota en la base de datos
            $sqlActualizarNota = $db->prepare("
                UPDATE nota
                SET $key = :nota
                WHERE id_nota = (
                    SELECT id_nota
                    FROM estadoalumno
                    WHERE id_persona = :id_persona
                    AND id_materia = :id_materia
                    AND id_ciclo = :id_ciclo
                )
            ");

            try {
                $sqlActualizarNota->bindParam(':nota', $value, PDO::PARAM_STR);
                $sqlActualizarNota->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
                $sqlActualizarNota->bindParam(':id_materia', $_POST['materia'], PDO::PARAM_INT);
                $sqlActualizarNota->bindParam(':id_ciclo', $_POST['ciclo_lectivo'], PDO::PARAM_INT);

                $sqlActualizarNota->execute();
            } catch (PDOException $e) {
                echo 'Error al actualizar la nota: ' . $e->getMessage();
            }
        }
    }

    echo 'Notas guardadas correctamente.';
} else {
    echo 'No se han recibido datos para guardar.';
}
