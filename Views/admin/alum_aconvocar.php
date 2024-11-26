<?php
require_once('../../conn/connection.php');

// Habilitar el manejo de errores en PDO
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ---------------------------------------------
// Obtener lista de alumnos y sus notas guardadas
// ---------------------------------------------
$id_mesa_examen = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_mesa_examen) {
    die("ID de mesa inválido.");
}

$query = "
    SELECT 
        persona.id_persona AS id_alumno, 
        persona.nombre, 
        persona.apellido, 
        persona.DNI, 
        mesa_examen.id_mesa, 
        mesa_examen.nombre_mesa,
        acta.escrito, 
        acta.oral, 
        acta.definitivo, 
        acta.asistencia 
    FROM inscripcion 
    INNER JOIN persona 
        ON inscripcion.id_alumno = persona.id_persona AND persona.estado = 'Activo'
    INNER JOIN mesa_examen 
        ON inscripcion.id_mesa_examen = mesa_examen.id_mesa AND mesa_examen.estado = 'Activo' 
    LEFT JOIN acta 
        ON acta.dni = persona.DNI AND acta.id_mesa = mesa_examen.id_mesa
    WHERE id_mesa_examen = :id_mesa_examen
";

$stmt = $db->prepare($query);
$stmt->bindParam(':id_mesa_examen', $id_mesa_examen, PDO::PARAM_INT);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ---------------------------------------------
// Guardar datos al presionar "Guardar Todos"
// ---------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_todos'])) {
    $alumnos = $_POST['alumnos'] ?? [];
    $id_mesa = filter_input(INPUT_POST, 'id_mesa', FILTER_VALIDATE_INT);

    foreach ($alumnos as $id_alumno => $datos) {
        $dni = filter_var($datos['dni'], FILTER_SANITIZE_NUMBER_INT);
        $n1 = isset($datos['escrito']) ? (float)$datos['escrito'] : null;
        $n2 = isset($datos['oral']) ? (float)$datos['oral'] : null;
        $asistencia = filter_var($datos['asistencia'] ?? '', FILTER_SANITIZE_STRING);
        $n3 = null;

        if ($asistencia === "Ausente") {
            $n1 = 0;
            $n2 = 0;
            $n3 = 0;
        } else {
            // Filtrar notas válidas (mayores a 0)
            $notas = [];
            if ($n1 > 0) $notas[] = $n1;
            if ($n2 > 0) $notas[] = $n2;
        
            // Calcular definitivo basado en las notas válidas
            if (count($notas) === 2) {
                $n3 = array_sum($notas) / count($notas); // Promediar si hay dos notas válidas
            } elseif (count($notas) === 1) {
                $n3 = $notas[0]; // Usar la única nota válida
            } else {
                $n3 = null; // No hay notas válidas
            }
        }
        
    
        try {
            $sql = "
                INSERT INTO acta (dni, ape_nom, escrito, oral, definitivo, asistencia, id_mesa)
                VALUES (:dni, :ape_nom, :escrito, :oral, :definitivo, :asistencia, :id_mesa)
                ON DUPLICATE KEY UPDATE
                escrito = :escrito, oral = :oral, definitivo = :definitivo, asistencia = :asistencia
            ";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':ape_nom', $datos['ape_nom']);
            $stmt->bindParam(':escrito', $n1);
            $stmt->bindParam(':oral', $n2);
            $stmt->bindParam(':definitivo', $n3);
            $stmt->bindParam(':asistencia', $asistencia);
            $stmt->bindParam(':id_mesa', $id_mesa, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $errores[] = "Error al guardar datos del alumno con DNI $dni: " . $e->getMessage();
        }
    }
    

}
require 'navbar.php';
?>

<!-- --------------------------------------------- -->
<!-- Vista: Listado de Alumnos -->
<!-- --------------------------------------------- -->
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header pb-0 bg-dark text-white">
                    <h4 class="d-inline-block">Listado de Alumnos a convocar</h4>
                <form action="imprimir.php" method="post">
                    <input type="hidden" name="id_mesa" value="<?php echo htmlspecialchars($id_mesa_examen); ?>">
                    <button type="submit" class="btn btn-primary float-right mb-2">Impresión de Acta</button>
                </form>
                </div>
                <div class="card-body table-responsive">
                    <form action="" method="post" onsubmit="return confirmarGuardar();">
                        <input type="hidden" name="id_mesa" value="<?php echo htmlspecialchars($id_mesa_examen); ?>">

                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <h5 class="d-inline-block">
                                <strong>
                                    Mesa de examen: <?php echo htmlspecialchars($resultados[0]['nombre_mesa'] ?? 'Sin nombre'); ?><br><br>
                                </strong>
                            </h5>
                            <thead class="thead-dark">
                                <tr>
                                    <th>Apellido y Nombre</th>
                                    <th>DNI</th>
                                    <th>Escrito</th>
                                    <th>Oral</th>
                                    <th>Definitivo</th>
                                    <th>Asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $resultado): 
                                    $readonly = $resultado['definitivo'] !== null ? 'readonly' : '';
                                    $asistencia = $resultado['asistencia'] ?? '';

                                ?>
                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($resultado['nombre'] . " " . $resultado['apellido']); ?>
                                            <input type="hidden" name="alumnos[<?php echo $resultado['id_alumno']; ?>][ape_nom]" value="<?php echo htmlspecialchars($resultado['nombre'] . " " . $resultado['apellido']); ?>">
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($resultado['DNI']); ?>
                                            <input type="hidden" name="alumnos[<?php echo $resultado['id_alumno']; ?>][dni]" value="<?php echo htmlspecialchars($resultado['DNI']); ?>">
                                        </td>
                                        <td>
                                            <input 
                                                type="number" 
                                                name="alumnos[<?php echo $resultado['id_alumno']; ?>][escrito]" 
                                                min="0" 
                                                max="10" 
                                                step="0.1" 
                                                class="form-control" 
                                                value="<?php echo htmlspecialchars($resultado['escrito'] ?? ''); ?>" 
                                                <?php echo $readonly; ?>>
                                        </td>
                                        <td>
                                            <input 
                                                type="number" 
                                                name="alumnos[<?php echo $resultado['id_alumno']; ?>][oral]" 
                                                min="0" 
                                                max="10" 
                                                step="0.1" 
                                                class="form-control" 
                                                value="<?php echo htmlspecialchars($resultado['oral'] ?? ''); ?>" 
                                                <?php echo $readonly; ?>>
                                        </td>
                                        <td>
                                            <input 
                                                type="number" 
                                                readonly 
                                                class="form-control" 
                                                value="<?php echo htmlspecialchars($resultado['definitivo'] ?? ''); ?>">
                                        </td>
                                        <td>
                                            <?php if ($asistencia): ?>
                                                <span class="badge 
                                                    <?php echo $asistencia === 'Presente' ? 'bg-success' : 
                                                                ($asistencia === 'Ausente' ? 'bg-danger' : 
                                                                'bg-warning'); ?>">
                                                    <?php echo htmlspecialchars($asistencia); ?>
                                                </span>
                                            <?php else: ?>
                                                <select  class="btn" onchange="cambiarColor(this)" 
                                                    name="alumnos[<?php echo $resultado['id_alumno']; ?>][asistencia]" 
                                                    class="form-control">
                                                    <option value=""  selected>Seleccione...</option>
                                                    <option value="Presente" class="btn-success">Presente</option>
                                                    <option value="Ausente" class="btn-danger">Ausente</option>
                                                    <option value="Justificado" class="btn-warning">Justificado</option>
                                                </select>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <hr>
                        <button type="submit" name="guardar_todos" class="btn btn-success float-right mb-2">Guardar Todos</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function cambiarColor(selectElement) {
    selectElement.classList.remove('btn-success', 'btn-danger', 'btn-warning');
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    if (selectedOption.classList.contains('btn-success')) {
        selectElement.classList.add('btn-success');
    } else if (selectedOption.classList.contains('btn-danger')) {
        selectElement.classList.add('btn-danger');
    } else if (selectedOption.classList.contains('btn-warning')) {
        selectElement.classList.add('btn-warning');
    }
}

function confirmarGuardado(event) {
    if (!confirm("¿Estás seguro de que deseas guardar los datos? Una vez guardados, no podrás modificarlos.")) {
        event.preventDefault(); 
    }
}
</script>
