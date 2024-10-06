<?php
require 'navbar.php';
require '../../conn/connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$alumno_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$alumno_id) {
    die("ID de alumno no especificado.");
}

$nombre_completo = obtenerNombreCompletoAlumno($conexion, $alumno_id);
$materias = obtenerMateriasActivas($conexion);
$inscripciones_alumno = obtenerInscripcionesAlumno($conexion, $alumno_id);
$ciclo = obtenerCicloLectivoActual($conexion);
$select_ciclo = $ciclo['id_ciclo'] ?? '';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = manejarInscripcion($conexion, $_POST);
    if($mensaje=='error'){
        $error="No puedes inscribirte a esta materia porque no has aprobado la correlativa.";
        $mensaje='';        
    }
}

function obtenerNombreCompletoAlumno($conexion, $alumno_id) {
    $stmt = $conexion->prepare("SELECT CONCAT(nombre, ' ', apellido) AS nombre_completo FROM persona WHERE id_persona = ?");
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['nombre_completo'] ?? "Alumno no encontrado";
}

function obtenerMateriasActivas($conexion) {
    $stmt = $conexion->prepare("SELECT * FROM materia WHERE estado = 'Activo'");
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
    $stmt = $conexion->prepare("SELECT id_correlativa FROM correlativa WHERE id_materia = ?");
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $correlativa = $stmt->get_result()->fetch_assoc();

    // Si no hay correlativa, retorna verdadero (puede inscribirse)
    if (!$correlativa || !$correlativa['id_correlativa']) {
        return true; 
    }

    // Verificar la nota de la correlativa
    $stmt = $conexion->prepare("SELECT n8 FROM nota WHERE id_persona = ? AND id_materia = ? AND estado = 'Activo'");
    $stmt->bind_param("ii", $alumno_id, $correlativa['id_correlativa']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $nota = $result->fetch_assoc();
        return $nota['n8'] >= 6; // Verificar si la calificación final es igual o mayor a 6
    }
    return false; // Si no hay nota, no se puede inscribir
}

function manejarInscripcion($conexion, $data) {
    $alumno_id = filter_input(INPUT_POST, 'alumno_id', FILTER_SANITIZE_NUMBER_INT);
    $materia_id = filter_input(INPUT_POST, 'materia_id', FILTER_SANITIZE_NUMBER_INT);
    $ciclo_lectivo = filter_input(INPUT_POST, 'ciclo_lectivo', FILTER_SANITIZE_NUMBER_INT);
    $fecha_inscripcion = date('Y-m-d H:i:s');

    if (!$alumno_id || !$materia_id || !$ciclo_lectivo) {
        return "Datos de inscripción incompletos.";
    }

    if (!verificarCorrelativaAprobada($conexion, $alumno_id, $materia_id)) {
        return "error";
    }

    // Comprobamos si el usuario es administrador
    $stmt = $conexion->prepare("SELECT id_rol FROM persona WHERE id_persona = ?");
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    $rol = $stmt->get_result()->fetch_assoc()['id_rol'];

    if ($rol != 3 && !verificarCorrelativaAprobada($conexion, $alumno_id, $materia_id)) {
        return "error";
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
                    <?php endforeach; ?>
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
                timer: 1000,
                showConfirmButton: false
            }).then(() => {
                const url = new URL(window.location);
                url.searchParams.delete('mensaje');
                window.history.replaceState(null, null, url);
                location.reload();
            });
        <?php endif; ?>
    });
</script>

<script>
      document.addEventListener("DOMContentLoaded", function() {
        <?php if ($error): ?>
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "<?php echo $error; ?>",
          timer: 1000,
          showConfirmButton: false,
          confirmButtonColor: "#d33"
        }).then(() => {
            const url = new URL(window.location);
                url.searchParams.delete('error');
                window.history.replaceState(null, null, url);
        });
        <?php endif; ?>
      });
    </script>

<?php require 'footer.php'; ?>
