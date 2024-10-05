<?php 
require 'navbar.php';
require '../../conn/connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$alumno_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($alumno_id) {
    $sql_alumno = "SELECT * FROM persona WHERE id_persona = ?";
    $stmt_alumno = $conexion->prepare($sql_alumno);
    $stmt_alumno->bind_param("i", $alumno_id);
    $stmt_alumno->execute();
    $result_alumno = $stmt_alumno->get_result();
    
    if ($result_alumno->num_rows > 0) {
        $alumno = $result_alumno->fetch_assoc();
        $nombre_completo = htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']);
    } else {
        $nombre_completo = "Alumno no encontrado";
    }

    // Obtén las materias inscritas
    $sql = "SELECT m.* FROM alumno_materia am
            JOIN materia m ON am.id_materia = m.id_materia
            WHERE am.id_persona = ? AND m.estado = 'Activo'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $materias[] = $row;
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'info',
                    title: 'Sin materias',
                    text: 'No se encontraron materias inscritas para este alumno.',
                    confirmButtonColor: '#6a1b9a', // Color lila pastel
                    confirmButtonText: 'Ok'
                });
              </script>";
    }

} else {
    echo "ID de alumno no especificado."; 
    exit;
}

//--------------BARRA DE CICLO LECTIVO ACTUAL----------------------
if (!isset($_POST['buscar'])) {
    $sql_ciclo = "SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1";
    $result_ciclo = $conexion->query($sql_ciclo);
    $ciclo = $result_ciclo->fetch_assoc();
    $select_ciclo = $ciclo['id_ciclo'];   
}

if (isset($_POST['buscar'])) {
    $select_ciclo = !empty($_POST['select_ciclo']) ? $_POST['select_ciclo'] : $select_ciclo;
}

// Función para obtener notas
function obtenerNotas($conexion, $alumno_id, $materia_id, $ciclo_id) {
    $sql_nota = "SELECT * FROM nota WHERE id_persona = ? AND id_materia = ? AND id_ciclo = ?";
    $stmt_nota = $conexion->prepare($sql_nota);
    $stmt_nota->bind_param("iii", $alumno_id, $materia_id, $ciclo_id);
    $stmt_nota->execute();
    return $stmt_nota->get_result()->fetch_assoc(); 
}

?>

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0 ">    
                    <div class="row">                
                        <h5 class="col"><?php echo $nombre_completo; ?></h5>     
                        <div class="col mb-2">
                            <form id="miFormulario" action="" method="post" class="form-inline justify-content-end my-1">
                                <select name="select_ciclo" class="form-control form-control-sm w-50" onchange="enviarFormulario()">
                                    <option value="" disabled selected class="text-secondary">Ciclo lectivo actual: <?php echo htmlspecialchars($ciclo['nombre_ciclo']); ?></option>
                                    <?php                          
                                    $stmt = $conexion->query("SELECT * FROM ciclo_lectivo");
                                    while ($row = $stmt->fetch_assoc()) {
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
                            </form>
                        </div>             
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="nota" class="table table-striped table-sm">
                        <thead class="thead-dark"> 
                            <tr>        
                                <th>ID</th>
                                <th>Materia</th>             
                                <th>Nota1</th>
                                <th>Nota2</th>
                                <th>Nota3</th>
                                <th>Nota4</th>
                                <th>Calif. Regular</th>
                                <th>Calif. 1º Ex. Final</th>
                                <th>Calif. 2º Ex. Final</th>
                                <th>Calif. Final</th>
                                <th>1º Per. Ev. Dic.</th>
                                <th>2º Per. Ev. Dic.</th>
                                <th>1º Per. Ev. Feb.</th>
                                <th>2º Per. Ev. Feb.</th>
                                <th>Calificación Definitiva</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            <?php if (isset($materias) && count($materias) > 0): ?>
                                <?php foreach ($materias as $index => $materia): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($materia['Nombre']); ?></td>
                                        <?php
                                        // Llamada a la función para obtener notas
                                        $mate = $materia['id_materia'];
                                        $nota = obtenerNotas($conexion, $alumno_id, $mate, $select_ciclo); 

                                        // Imprimir notas
                                        for ($i = 1; $i <= 4; $i++) {
                                            echo '<td>' . (isset($nota["n$i"]) ? htmlspecialchars($nota["n$i"]) : '-') . '</td>';
                                        }

                                        // Imprimir calificaciones regulares y finales
                                        echo '<td>' . (isset($nota['n5']) ? htmlspecialchars($nota['n5']) : '-') . '</td>'; // Cambia 'calificacion_regular' por 'n5'
                                        echo '<td>' . (isset($nota['n6']) ? htmlspecialchars($nota['n6']) : '-') . '</td>'; // Cambia 'calificacion_1_ex_final' por 'n6'
                                        echo '<td>' . (isset($nota['n7']) ? htmlspecialchars($nota['n7']) : '-') . '</td>'; // Cambia 'calificacion_2_ex_final' por 'n7'
                                        echo '<td>' . (isset($nota['n8']) ? htmlspecialchars($nota['n8']) : '-') . '</td>'; // Cambia 'calificacion_final' por 'n8'
                                        echo '<td>' . (isset($nota['n9']) ? htmlspecialchars($nota['n9']) : '-') . '</td>'; // Cambia 'primer_per_evaluacion_dic' por 'n9'
                                        echo '<td>' . (isset($nota['n10']) ? htmlspecialchars($nota['n10']) : '-') . '</td>'; // Cambia 'segundo_per_evaluacion_dic' por 'n10'
                                        echo '<td>' . (isset($nota['n11']) ? htmlspecialchars($nota['n11']) : '-') . '</td>'; // Cambia 'primer_per_evaluacion_feb' por 'n11'
                                        echo '<td>' . (isset($nota['n12']) ? htmlspecialchars($nota['n12']) : '-') . '</td>'; // Cambia 'segundo_per_evaluacion_feb' por 'n12'
                                        echo '<td>' . (isset($nota['n13']) ? htmlspecialchars($nota['n13']) : '-') . '</td>'; // Cambia 'calificacion_definitiva' por 'n13'
                                        ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="15" class="text-center">No se encontraron materias inscritas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
