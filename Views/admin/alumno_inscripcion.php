<?php
ob_start();
require 'navbar.php';
require '../../conn/connection.php';

if (!isset($_SESSION['id_persona'])) {
    die("Error: No has iniciado sesión.");
}

$alumno_id = $_SESSION['id_persona'];
$nombre_completo = obtenerNombreCompletoAlumno($conexion, $alumno_id);
$materias = obtenerMateriasActivas($conexion);
$inscripciones_alumno = obtenerInscripcionesAlumno($conexion, $alumno_id);
$ciclo = obtenerCicloLectivoActual($conexion);
$select_ciclo = $ciclo['id_ciclo'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = manejarInscripcion($conexion, $_POST, $alumno_id);
    $_SESSION['mensaje'] = $mensaje;
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $alumno_id);
    exit();
}

function obtenerNombreCompletoAlumno($conexion, $alumno_id)
{
    $stmt = $conexion->prepare("SELECT CONCAT(nombre, ' ', apellido) AS nombre_completo FROM persona WHERE id_persona = ?");
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['nombre_completo'] ?? "Alumno no encontrado";
}

function obtenerMateriasActivas($conexion)
{
    $stmt = $conexion->prepare("SELECT * FROM materia WHERE estado = 'Activo'");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function obtenerInscripcionesAlumno($conexion, $alumno_id)
{
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

function obtenerCicloLectivoActual($conexion)
{
    $stmt = $conexion->prepare("SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1");
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
function manejarInscripcion($conexion, $data, $alumno_id)
{
    $materias_ids = filter_input(INPUT_POST, 'materias_ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $ciclo_lectivo = filter_input(INPUT_POST, 'ciclo_lectivo', FILTER_SANITIZE_NUMBER_INT);
    $fecha_inscripcion = date('Y-m-d H:i:s');

    if (empty($materias_ids) || !$ciclo_lectivo) {
        return "Datos de inscripción incompletos.";
    }

    $conexion->begin_transaction();

    try {
        foreach ($materias_ids as $materia_id) {
            // Verificar si el alumno ya aprobó la materia
            $stmt = $conexion->prepare("SELECT n13 FROM nota WHERE id_persona = ? AND id_materia = ?");
            $stmt->bind_param("ii", $alumno_id, $materia_id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $nota = $resultado->fetch_assoc();

            if ($nota && $nota['n13'] > 4) {
                continue; // Saltar esta materia, ya aprobada
            }

            // Verificar el rol para las correlativas
            $stmt = $conexion->prepare("SELECT id_rol FROM persona WHERE id_persona = ?");
            $stmt->bind_param("i", $alumno_id);
            $stmt->execute();
            $rol = $stmt->get_result()->fetch_assoc()['id_rol'];

            // Si el rol no es Admin y las correlativas no están aprobadas, cancelar inscripción
            if ($rol != 3 && !verificarCorrelativaAprobada($conexion, $alumno_id, $materia_id)) {
                continue; // No se inscribe a esta materia
            }

            // Insertar o actualizar inscripción
            $stmt = $conexion->prepare("INSERT INTO alumno_materia (id_persona, id_materia, id_ciclo, estado, fecha_inscripcion) 
                                        VALUES (?, ?, ?, 'Inscripto', ?) 
                                        ON DUPLICATE KEY UPDATE estado = 'Inscripto', fecha_inscripcion = ?");
            $stmt->bind_param("iiiss", $alumno_id, $materia_id, $ciclo_lectivo, $fecha_inscripcion, $fecha_inscripcion);
            $stmt->execute();
        }

        $conexion->commit();
        return "Inscripciones realizadas con éxito.";
    } catch (Exception $e) {
        $conexion->rollback();
        return "Error: " . $e->getMessage();
    }
}

// Aquí se incluiría la parte HTML para el formulario

// Agrupar materias por año de cursado
$materias_por_año = [];
foreach ($materias as $materia) {
    $año_cursado = $materia['año_cursado'] ?? 'Sin especificar';
    $materias_por_año[$año_cursado][] = $materia;
}
?>

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block"><?php echo htmlspecialchars($nombre_completo); ?></h5>
                </div>
                <div class="card-body table-responsive">
                    <?php if (empty($materias)): ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Advertencia',
                                    text: 'No hay materias disponibles para inscripción.',
                                    timer: 3000,
                                    showConfirmButton: true
                                });
                            });
                        </script>
                    <?php endif; ?>

                    <?php foreach ($materias_por_año as $año => $materias): ?>
                        <h4>Materias por Año: <?php echo htmlspecialchars($año); ?></h4>
                        <table class="table table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Materia</th>
                                    <th>Cuatrimestre</th>
                                    <th>Ciclo Lectivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($materias as $index => $materia): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($materia['Nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($materia['plan_estudio']); ?></td>
                                        <td><?php echo htmlspecialchars($ciclo['nombre_ciclo']); ?></td>
                                        <td>
                                            <?php if (isset($inscripciones_alumno[$materia['id_materia']][$select_ciclo]) && $inscripciones_alumno[$materia['id_materia']][$select_ciclo] == 'Inscripto'): ?>
                                                <button class="btn btn-success btn-sm btn-block" disabled>Inscripto</button>
                                            <?php else: ?>
                                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $alumno_id; ?>" method="post">
                                                    <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>">
                                                    <input type="hidden" name="materias_ids[]" value="<?php echo $materia['id_materia']; ?>">
                                                    <input type="hidden" name="ciclo_lectivo" value="<?php echo $select_ciclo; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm btn-block">Inscribir</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                    <?php if (isset($_SESSION['mensaje'])): ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Resultado',
                                    text: '<?php echo $_SESSION['mensaje']; ?>',
                                    timer: null,
                                    showConfirmButton: true
                                });
                            });
                        </script>
                        <?php unset($_SESSION['mensaje']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?
ob_end_flush(); // Finaliza el buffer de salida
