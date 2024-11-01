<?php
ob_start(); // Inicia el buffer de salida
require 'navbar.php';
require '../../conn/connection.php';


// Verificamos que el usuario ha iniciado sesión
if (!isset($_SESSION['id_persona'])) {
    die("Error: No has iniciado sesión.");
}

// Obtenemos el ID del alumno directamente de la sesión
$alumno_id = $_SESSION['id_persona'];

// Función para obtener mesas de examen con año y plan de estudio
function obtenerMesasExamen($conexion, $alumno_id) {
    $stmt = $conexion->prepare("
        SELECT m.id_mesa, m.fecha, m.hora, m.nombre_mesa, ma.nombre AS nombre_materia,
               GROUP_CONCAT(DISTINCT ma.año_cursado SEPARATOR ', ') AS años_cursados,
               c.nombre_ciclo, ma.plan_estudio,
               (SELECT COUNT(*) FROM inscripcion WHERE id_alumno = ? AND id_mesa_examen = m.id_mesa) AS inscrito
        FROM mesa_examen m
        JOIN materia ma ON m.id_materia = ma.id_materia
        JOIN ciclo_lectivo c ON m.id_ciclo = c.id_ciclo
        JOIN nota n ON n.id_materia = ma.id_materia
        WHERE n.id_persona = ? 
          AND n.n5 >= 6
          AND c.ciclo_actual = 1
        GROUP BY m.id_mesa, ma.nombre, c.nombre_ciclo, ma.plan_estudio
    ");
    $stmt->bind_param("ii", $alumno_id, $alumno_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Guardar la inscripción a la mesa si se cumplen los requisitos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mesa_id = filter_input(INPUT_POST, 'mesa_id', FILTER_SANITIZE_NUMBER_INT);
    $fecha_inscripcion = date('Y-m-d H:i:s');
    
    $stmt = $conexion->prepare("INSERT INTO inscripcion (id_alumno, id_mesa_examen, fecha_inscripcion) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $alumno_id, $mesa_id, $fecha_inscripcion);
    
    if ($stmt->execute()) {
        echo "<script>Swal.fire('Éxito', 'Inscripción realizada con éxito', 'success');</script>";
    } else {
        echo "<script>Swal.fire('Error', 'Hubo un problema con la inscripción', 'error');</script>";
    }
}

// Listamos las mesas de examen disponibles
$mesas_examen = obtenerMesasExamen($conexion, $alumno_id);
?>

<!-- Incluir SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Inscripción a Mesa de Examen Final</h5>
                </div>
                <div class="card-body">
                    <?php if (count($mesas_examen) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Materia</th>
                                        <th>Años Cursados</th>
                                        <th>Plan de Estudio</th>
                                        <th>Mesa</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Ciclo Lectivo</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mesas_examen as $mesa): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($mesa['nombre_materia']); ?></td>
                                            <td><?php echo htmlspecialchars($mesa['años_cursados']); ?></td>
                                            <td><?php echo htmlspecialchars($mesa['plan_estudio']); ?></td>
                                            <td><?php echo htmlspecialchars($mesa['nombre_mesa']); ?></td>
                                            <td><?php echo htmlspecialchars(date("d/m/Y", strtotime($mesa['fecha']))); ?></td>
                                            <td><?php echo htmlspecialchars(date("H:i", strtotime($mesa['hora']))); ?></td>
                                            <td><?php echo htmlspecialchars($mesa['nombre_ciclo']); ?></td>
                                            <td>
                                                <?php if ($mesa['inscrito'] > 0): ?>
                                                    <button class="btn btn-success btn-sm" disabled>Inscripto</button>
                                                <?php else: ?>
                                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                        <button type="submit" name="mesa_id" value="<?php echo $mesa['id_mesa']; ?>" class="btn btn-primary btn-sm">
                                                            Inscribirse
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            No tienes mesas de examen disponibles con el promedio mínimo requerido.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
ob_end_flush(); // Finaliza el buffer de salida
?>
