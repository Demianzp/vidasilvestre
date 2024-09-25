<?php
require 'navbar.php';
require '../../conn/connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener el ID del alumno de la URL
$alumno_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$alumno_id) {
    die("ID de alumno no especificado.");
}

// Obtener datos del alumno y ciclo lectivo
$nombre_completo = obtenerNombreCompletoAlumno($conexion, $alumno_id);
$materias = obtenerMateriasActivas($conexion);
$inscripciones_alumno = obtenerInscripcionesAlumno($conexion, $alumno_id);
$ciclo = obtenerCicloLectivoActual($conexion);
$select_ciclo = $ciclo['id_ciclo'] ?? '';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = manejarInscripcion($conexion, $_POST);
}

// Funciones (omitiendo para brevedad)
function obtenerNombreCompletoAlumno($conexion, $alumno_id) {
    $stmt = $conexion->prepare("SELECT CONCAT(nombre, ' ', apellido) AS nombre_completo FROM persona WHERE id_persona = ?");
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['nombre_completo'] ?? "Alumno no encontrado";
}

function obtenerMateriasActivas($conexion) {
    $stmt = $conexion->prepare("SELECT id_materia, Nombre FROM materia WHERE estado = 'Activo'");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function obtenerInscripcionesAlumno($conexion, $alumno_id) {
    $stmt = $conexion->prepare("SELECT id_materia, id_ciclo, estado FROM alumno_materia WHERE id_persona = ?");
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $inscripciones = [];
    while ($row = $result->fetch_assoc()) {
        $inscripciones[$row['id_materia']][$row['id_ciclo']] = $row['estado'];
    }
    return $inscripciones;
}

function obtenerCicloLectivoActual($conexion) {
    $stmt = $conexion->prepare("SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1");
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function verificarCorrelativaAprobada($conexion, $alumno_id, $materia_id) {
    // Obtener la correlativa de la materia
    $stmt = $conexion->prepare("SELECT id_correlativa FROM correlativa WHERE id_materia = ?");
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $correlativa = $stmt->get_result()->fetch_assoc();
    
    if ($correlativa && $correlativa['id_correlativa']) {
        // Obtener el promedio de las notas del alumno para la materia correlativa
        $stmt = $conexion->prepare("SELECT AVG(n1 + n2 + n3 + n4 + n5 + n6 + n7 + n8 + n9 + n10 + n11 + n12 + n13) AS promedio 
                                     FROM nota 
                                     WHERE id_persona = ? AND id_materia = ? AND estado = 'Activo'");
        $stmt->bind_param("ii", $alumno_id, $correlativa['id_correlativa']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $nota = $result->fetch_assoc();
            // Verificar si el promedio es suficiente para aprobar (suponiendo que se requiere al menos 6)
            return $nota['promedio'] >= 6; // Cambia 6 por la calificación mínima para aprobar
        }
    }
    return true; // Si no hay correlativa, se permite la inscripción
}
function manejarInscripcion($conexion, $data) {
    $alumno_id = filter_input(INPUT_POST, 'alumno_id', FILTER_SANITIZE_NUMBER_INT);
    $materia_id = filter_input(INPUT_POST, 'materia_id', FILTER_SANITIZE_NUMBER_INT);
    $ciclo_lectivo = filter_input(INPUT_POST, 'ciclo_lectivo', FILTER_SANITIZE_NUMBER_INT);
    $fecha_inscripcion = date('Y-m-d H:i:s');

    if (!$alumno_id || !$materia_id || !$ciclo_lectivo) {
        return "Datos de inscripción incompletos.";
    }

    // Verificar si la materia correlativa ha sido aprobada
    if (!verificarCorrelativaAprobada($conexion, $alumno_id, $materia_id)) {
        return "No puedes inscribirte a esta materia porque no has aprobado la correlativa.";
    }

    $conexion->begin_transaction();

    try {
        $stmt = $conexion->prepare("INSERT INTO alumno_materia (id_persona, id_materia, id_ciclo, estado, fecha_inscripcion) 
                                    VALUES (?, ?, ?, 'Inscripto', ?) 
                                    ON DUPLICATE KEY UPDATE estado = 'Inscripto', fecha_inscripcion = ?");
        $stmt->bind_param("iiiss", $alumno_id, $materia_id, $ciclo_lectivo, $fecha_inscripcion, $fecha_inscripcion);
        
        if ($stmt->execute()) {
            $conexion->commit();
            return "Inscripción realizada con éxito.";
        } else {
            $conexion->rollback();
            return "Error al realizar la inscripción: " . $stmt->error;
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
                    <h5 class="d-inline-block"><?php echo htmlspecialchars($nombre_completo); ?></h5>
                </div>
                <div class="card-body table-responsive">
                    <p class="d-inline text-success">Ciclo lectivo actual: <?php echo htmlspecialchars($ciclo['nombre_ciclo']); ?></p>
                    <?php if ($mensaje): ?>
                        <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
                    <?php endif; ?>
                    
                    <!-- Verificación si no hay materias -->
                    <?php if (empty($materias)): ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Advertencia',
                                    text: 'No hay materias disponibles para inscripción.',
                                    timer: 3000,
                                    showConfirmButton: false
                                }).then(function() {
                                    window.location.href = 'alumno_index.php';
                                });
                            });
                        </script>
                    <?php endif; ?>

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
                                    <?php if (isset($inscripciones_alumno[$materia['id_materia']][$select_ciclo]) && $inscripciones_alumno[$materia['id_materia']][$select_ciclo] == 'Inscripto'): ?>
                                        <button class="btn btn-success btn-sm btn-block" disabled>Inscripto</button>
                                    <?php else: ?>
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $alumno_id; ?>" method="post">
                                            <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>">
                                            <input type="hidden" name="materia_id" value="<?php echo $materia['id_materia']; ?>">
                                            <input type="hidden" name="ciclo_lectivo" value="<?php echo $select_ciclo; ?>">
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

<!-- SweetAlert para manejar mensajes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($mensaje): ?>
            Swal.fire({
                icon: '<?php echo strpos($mensaje, 'Error') !== false ? 'error' : 'success'; ?>',
                title: '<?php echo strpos($mensaje, 'Error') !== false ? 'Error' : 'Éxito'; ?>',
                text: '<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>',
                timer: 3000,
                showConfirmButton: false
            }).then(function() {
                // Redirigir solo si hay un mensaje de éxito, puedes ajustar esto según necesites
                if (<?php echo strpos($mensaje, 'Error') === false ? 'true' : 'false'; ?>) {
                    window.location.href = 'alumno_index.php';
                }
            });
        <?php endif; ?>
    });
</script>

<?php require 'footer.php'; ?>
