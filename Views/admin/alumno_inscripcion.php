<?php
require 'navbar.php';
require '../../conn/connection.php';

// Obtener el ID del alumno de la URL
$alumno_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$alumno_id) {
    echo "ID de alumno no especificado.";
    exit;
}

// Obtener datos del alumno y ciclo lectivo
$nombre_completo = obtenerNombreCompletoAlumno($conexion, $alumno_id);
$materias = obtenerMateriasActivas($conexion);
$estado_alumno = obtenerEstadoAlumno($conexion, $alumno_id);
$ciclo = obtenerCicloLectivoActual($conexion);
$select_ciclo = $ciclo['id_ciclo'] ?? '';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = manejarInscripcion($conexion, $_POST);
}

function obtenerNombreCompletoAlumno($conexion, $alumno_id) {
    $stmt = $conexion->prepare("SELECT nombre, apellido FROM persona WHERE id_persona = ?");
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $alumno = $result->fetch_assoc();
    return $alumno ? htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']) : "Alumno no encontrado";
}

function obtenerMateriasActivas($conexion) {
    $stmt = $conexion->prepare("SELECT id_materia, Nombre FROM materia WHERE estado = 'Activo'");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerEstadoAlumno($conexion, $alumno_id) {
    $stmt = $conexion->prepare("SELECT id_materia, estado FROM alumno_materia WHERE id_persona = ?");
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $estado_alumno = [];
    while ($row = $result->fetch_assoc()) {
        $estado_alumno[$row['id_materia']] = $row['estado'];
    }
    return $estado_alumno;
}

function obtenerCicloLectivoActual($conexion) {
    $stmt = $conexion->prepare("SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1");
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function manejarInscripcion($conexion, $data) {
    $alumno_id = filter_input(INPUT_POST, 'alumno_id', FILTER_SANITIZE_NUMBER_INT);
    $materia_id = filter_input(INPUT_POST, 'materia_id', FILTER_SANITIZE_NUMBER_INT);
    $ciclo_lectivo = filter_input(INPUT_POST, 'ciclo_lectivo', FILTER_SANITIZE_NUMBER_INT);
    $fecha_inscripcion = date('Y-m-d H:i:s');

    $errores = [];

    if (!$alumno_id) {
        $errores[] = "ID del alumno no especificado.";
    }
    if (!$materia_id) {
        $errores[] = "ID de la materia no especificado.";
    }
    if (!$ciclo_lectivo) {
        $errores[] = "ID del ciclo lectivo no especificado.";
    }

    if (!empty($errores)) {
        return implode(' ', $errores);
    }

    $conexion->begin_transaction();

    try {
        $stmt_check = $conexion->prepare("SELECT * FROM alumno_materia WHERE id_persona = ? AND id_materia = ? AND id_ciclo = ?");
        $stmt_check->bind_param("iii", $alumno_id, $materia_id, $ciclo_lectivo);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $stmt_update = $conexion->prepare("UPDATE alumno_materia SET estado = 'Inscripto', fecha_inscripcion = ? WHERE id_persona = ? AND id_materia = ? AND id_ciclo = ?");
            $stmt_update->bind_param("siii", $fecha_inscripcion, $alumno_id, $materia_id, $ciclo_lectivo);
            if ($stmt_update->execute()) {
                $conexion->commit();
                return "Inscripción actualizada.";
            } else {
                $conexion->rollback();
                return "Error al actualizar la inscripción: " . $stmt_update->error;
            }
        } else {
            $stmt_insert = $conexion->prepare("INSERT INTO alumno_materia (id_persona, id_materia, id_ciclo, estado, fecha_inscripcion) VALUES (?, ?, ?, 'Inscripto', ?)");
            $stmt_insert->bind_param("iiis", $alumno_id, $materia_id, $ciclo_lectivo, $fecha_inscripcion);
            if ($stmt_insert->execute()) {
                $conexion->commit();
                return "Inscripción exitosa.";
            } else {
                $conexion->rollback();
                return "Error al realizar la inscripción: " . $stmt_insert->error;
            }
        }
    } catch (Exception $e) {
        $conexion->rollback();
        return "Error: " . $e->getMessage();
    }
}
?>

<!-- HTML del formulario de inscripción -->
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block"><?php echo $nombre_completo; ?></h5>
                </div>
                <div class="card-body table-responsive">
                    <p class="d-inline text-success">Ciclo lectivo actual: <?php echo htmlspecialchars($ciclo['nombre_ciclo']); ?></p>
                    <br>
                    
                    <!-- Materias -->
                    <table class="table table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Materia</th>
                                <th>Inscripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materias as $index => $materia): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($materia['Nombre']); ?></td>
                                <td>
                                    <?php if (isset($estado_alumno[$materia['id_materia']]) && $estado_alumno[$materia['id_materia']] == 'Inscripto'): ?>
                                        <button class="btn btn-success btn-sm btn-block" disabled>Inscripto</button>
                                    <?php else: ?>
                                        <form action="alumno_inscripcion.php?id=<?php echo htmlspecialchars($alumno_id); ?>" method="post">
                                            <input type="hidden" name="alumno_id" value="<?php echo htmlspecialchars($alumno_id); ?>">
                                            <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia['id_materia']); ?>">
                                            <input type="hidden" name="ciclo_lectivo" value="<?php echo htmlspecialchars($select_ciclo); ?>">
                                            <button type="submit" class="btn btn-danger btn-sm btn-block">Inscribir</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($mensaje): ?>
            Swal.fire({
                icon: '<?php echo strpos($mensaje, 'Error') !== false ? 'error' : 'success'; ?>',
                title: '<?php echo strpos($mensaje, 'Error') !== false ? 'Error' : 'Éxito'; ?>',
                text: '<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>',
                timer: 3000,  // Mostrar el mensaje durante 3 segundos
                showConfirmButton: false
            }).then(function() {
                // Redirigir al archivo alumno_index.php después de mostrar el mensaje
                window.location.href = 'alumno_index.php';
            });
        <?php endif; ?>
    });
</script>

<?php require 'footer.php'; ?>
