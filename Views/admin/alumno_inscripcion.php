<?php
ob_start(); // Inicia el buffer de salida
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = manejarInscripcion($conexion, $_POST, $alumno_id);
    $_SESSION['mensaje'] = $mensaje;
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $alumno_id);
    exit();
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
    // Obtener todas las correlativas para la materia
    $stmt = $conexion->prepare("SELECT id_correlativa FROM correlativa WHERE id_materia = ?");
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $result = $stmt->get_result();
    // Si no hay correlativas, se puede inscribir
    if ($result->num_rows === 0) {
        return true;
    }
    // Iterar sobre cada correlativa y verificar si está aprobada
    while ($correlativa = $result->fetch_assoc()) {

        $stmt = $conexion->prepare("SELECT n5 FROM nota WHERE id_persona = ? AND id_materia = ? AND estado = 'Activo'");
        $stmt->bind_param("ii", $alumno_id, $correlativa['id_correlativa']);
        $stmt->execute();
        $nota_result = $stmt->get_result();
        // Si la correlativa no tiene nota aprobada, retornar false
        if ($nota_result->num_rows === 0) {
            return false;
        }
        $nota = $nota_result->fetch_assoc();
        if ($nota['n5'] < 6) {
            return false; // Correlativa no aprobada
        }
    }
    return true;
}

function manejarInscripcion($conexion, $data, $alumno_id) {
    $materia_id = filter_input(INPUT_POST, 'materia_id', FILTER_SANITIZE_NUMBER_INT);
    $ciclo_lectivo = filter_input(INPUT_POST, 'ciclo_lectivo', FILTER_SANITIZE_NUMBER_INT);
    $fecha_inscripcion = date('Y-m-d H:i:s');

    if (!$materia_id || !$ciclo_lectivo) {
        return "Datos de inscripción incompletos.";
    }

    $stmt = $conexion->prepare("SELECT id_rol FROM persona WHERE id_persona = ?");
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    $rol = $stmt->get_result()->fetch_assoc()['id_rol'];

    if ($rol != 3 && !verificarCorrelativaAprobada($conexion, $alumno_id, $materia_id)) {
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
                    <div class="row">
                    <h5 class="col"><?php echo htmlspecialchars($nombre_completo); ?></h5>
                    <div class="col mb-2">
                            <!-- <form id="miFormulario" action="" method="post" class="form-inline justify-content-end my-1">
                                <select name="select_ciclo" class="form-control form-control-sm w-50" onchange="enviarFormulario()">
                                    <option value="" disabled selected class="text-secondary">Ciclo lectivo actual: <?php echo $ciclo['nombre_ciclo']; ?></option>
                                    <?php                          
                                    $stmt = $db->query("SELECT * FROM ciclo_lectivo");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row["id_ciclo"]}'>{$row["nombre_ciclo"]}</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="buscar" >
                                <script>
                                    function enviarFormulario() {
                                        document.getElementById("miFormulario").submit();
                                    }
                                </script>
                            </form> -->
                        </div> 
                    </div>
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
                                    <th >Acciones</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($materias as $index => $materia): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($materia['Nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($materia['plan_estudio']); ?></td>
                                    <td><?php echo htmlspecialchars($ciclo['nombre_ciclo']); ?></td>
                                    <!-- -------------------------------------------------------- -->
                                    <?php 
                                        $mate=$materia['id_materia'];
                                        $sql_nota = "SELECT * FROM nota 
                                        WHERE id_persona = $alumno_id 
                                        AND id_materia = $mate
                                        ";                                           
                                        $result_nota = $conexion->query($sql_nota);    
                                        $nota = $result_nota->fetch_assoc(); 
                                        if(empty($nota['n13'])){$nota13=null;}else{$nota13= $nota['n13'];}
                                        if(empty($nota['n5'])){$nota5 =null;}else{$nota5= $nota['n5'];}
                                    ?>
                                    <!-- --------Condicion para poner nombres a las notas redondeado hacia abajo------------- -->
                                    <?php
                                    $numeros = [1 => "Uno", 2 => "Dos", 3 => "Tres", 4 => "Cuatro", 5 => "Cinco", 6 => "Seis", 7 => "Siete", 8 => "Ocho", 9 => "Nueve", 10 => "Diez"];
                                    if (isset($nota13) && is_numeric($nota13)) {
                                        $nota_redondeada_abajo = floor($nota13);
                                    } 
                                    ?>
                                    <!-- --------------------------------------- -->
                                    <td >                                        
                                        <?php if (isset($inscripciones_alumno[$materia['id_materia']][$select_ciclo]) && $inscripciones_alumno[$materia['id_materia']][$select_ciclo] == 'Inscripto' && !isset($nota13)&&!isset($nota5)): ?>
                                            <button class="btn btn-primary btn-sm btn-block mx-0 px-0" disabled>Inscripto</button>                                                                                        
                                        <?php elseif ((isset($nota13) && $nota13 >= 4) && (isset($nota5) && $nota5 >= 6)): ?>
                                            <button class="btn btn-success btn-sm btn-block mx-0 px-0" disabled>Aprobado <?php echo "(".$nota13." ".$numeros[$nota_redondeada_abajo].")";?></button>
                                        <?php elseif ((isset($nota13) && $nota13 < 4 && $select_ciclo == $nota['id_ciclo']) || (isset($nota5) && $nota5 < 6 && $select_ciclo == $nota['id_ciclo'])): ?>
                                            <button class="btn btn-warning btn-sm btn-block mx-0 px-0" disabled>Libre</button>
                                        <?php elseif ((isset($nota5) && $nota5 >= 6 && $select_ciclo == $nota['id_ciclo'])): ?>
                                            <button class="btn btn-secondary btn-sm btn-block mx-0 px-0" disabled>Regular</button>
                                        <?php else: ?>
                                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . htmlspecialchars($alumno_id); ?>" method="post">
                                                <input type="hidden" name="alumno_id" value="<?php echo htmlspecialchars($alumno_id); ?>">
                                                <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia['id_materia']); ?>">
                                                <input type="hidden" name="ciclo_lectivo" value="<?php echo htmlspecialchars($select_ciclo); ?>">
                                                <button type="submit" class="btn btn-danger btn-sm btn-block mx-0 px-0">Inscribir</button>
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