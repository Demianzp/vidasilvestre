<?php require 'navbar.php';
require '../../conn/connection.php';
// Obtener el ID del alumno de la URL
$alumno_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($alumno_id) {
    $sql_alumno = "SELECT nombre, apellido FROM persona WHERE id_persona = $alumno_id";
    $result_alumno = $conexion->query($sql_alumno);
    if ($result_alumno->num_rows > 0) {
        $alumno = $result_alumno->fetch_assoc();
        $nombre_completo = $alumno['nombre'] . ' ' . $alumno['apellido'];
    } else {
        $nombre_completo = "Alumno no encontrado";
    }
    $sql = "SELECT id_materia, Nombre, estado  FROM materia where estado = 'Activo'";
    $result = $conexion->query($sql);
    $materias = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $materias[] = $row;
        }
    } else {
        echo "No se encontraron materias.";
        
    }
    $sql_estado = "SELECT * FROM alumno_materia WHERE id_persona = $alumno_id";
    $result_estado = $conexion->query($sql_estado);    
    $estado_alumno = [];
    if ($result_estado->num_rows > 0) {
        while ($row_estado = $result_estado->fetch_assoc()) {
            $estado_alumno[$row_estado['id_materia']] = $row_estado['estado'];
        }
    }    
} else {
    echo "ID de alumno no especificado.";
    exit;
}
?>
<!-- ------------------------------------- -->
<section class="content mt-3  " >
    <div class="row m-auto" >
        <div class="col-sm " >
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block"><?php echo htmlspecialchars($nombre_completo); ?></h5>            
                </div>
                <div class="card-body table-responsive">
            <!-- ------------------------------------------------------------- -->
            <?php 
             if(!isset($_POST['buscar'])){
                $sql_ciclo = "SELECT id_ciclo , nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1";
                $result_ciclo = $conexion->query($sql_ciclo);
                $ciclo = $result_ciclo->fetch_assoc();
                $select_ciclo = $ciclo['id_ciclo'];   
                }             
             ?>                 
           <!-- ------------------------------------------------------------- -->
           <p class="d-inline text-success">ciclo lectivo actual: <?php echo $ciclo['nombre_ciclo']; ?></p>
           <br>            
           <!-- ------------------------------------------------------------- -->
           <table id="" class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                    <th id="notas">#</th>
                        <th id="notas">Materia</th>
                        <th id="notas">Inscribir</th>                                
                    </tr>
                </thead>
                <!-- ---------- -->
                <?php
                    $sql_estado = "SELECT * FROM alumno_materia WHERE id_persona = $alumno_id AND estado = 'Inscripto' AND id_ciclo = $select_ciclo";
                    $result_estado = $conexion->query($sql_estado);    
                    $estado = $result_estado->fetch_assoc();
                    //$ciclo_estado = $estado['id_ciclo'];                            
                 ?>
                 <!-- -------- -->
                <tbody>
                <?php foreach ($materias as $index => $materia): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($materia['Nombre']); ?></td>
                    <td>
                        <?php if (isset($estado_alumno[$materia['id_materia']]) 
                                        && $estado_alumno[$materia['id_materia']] == 'Inscripto'                                         
                                        ): ?>                                                         
                            <div class="bg-success text-white text-center">Inscripto</div>
                        <?php else: ?>
                            <form action="alumno_inscripcion.php" method="post">
                                <input type="hidden" name="alumno_id" value="<?php echo htmlspecialchars($alumno_id); ?>">
                                <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia['id_materia']); ?>">
                                <input type="hidden" name="ciclo_lectivo" value="<?php echo htmlspecialchars($select_ciclo); ?>">
                                <button type="submit" class="btn btn-danger btn-sm btn-block">Inscribir</button>
                            </form>                            
                        <?php endif; ?>
                        <!-- <?php echo  $select_ciclo  ."_".  $estado_alumno[$materia['id_materia']] ; ?> -->
                        </td>
                        <?php endforeach; ?>
                </tbody>
            </div>    
            </div> 
        </div>   
    </div>
</section>
<!-- ----------------------------------------------------------------- -->
<?php
$alumno_id = isset($_POST['alumno_id']) ? $_POST['alumno_id'] : null;
$materia_id = isset($_POST['materia_id']) ? $_POST['materia_id'] : null;
$ciclo_lectivo = isset($_POST['ciclo_lectivo']) ? $_POST['ciclo_lectivo'] : null;
if ($alumno_id && $materia_id && $ciclo_lectivo) {
    // Verificar si ya existe un registro para este alumno y materia en el ciclo lectivo actual
    $sql_check = "SELECT * FROM alumno_materia WHERE id_persona = $alumno_id AND id_materia = $materia_id AND id_ciclo = $ciclo_lectivo";
    $result_check = $conexion->query($sql_check);
    if ($result_check->num_rows > 0) {
        // Actualizar el estado a "Inscripto"
        $sql_update = "UPDATE alumno_materia SET estado = 'Inscripto' WHERE id_persona = $alumno_id AND id_materia = $materia_id AND id_ciclo = $ciclo_lectivo";
        if ($conexion->query($sql_update) === TRUE) {
            echo "Inscripción actualizada.";
        } else {
            echo "Error: " . $sql_update . "<br>" . $conexion->error;
        }
    } else {
        // Insertar un nuevo registro
        $sql_insert = "INSERT INTO alumno_materia (id_persona, id_materia, id_ciclo, estado) VALUES ($alumno_id, $materia_id, $ciclo_lectivo, 'Inscripto')";
        if ($conexion->query($sql_insert) === TRUE) {
            echo "Inscripción exitosa.";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conexion->error;
        }
    }
} else {
    echo "Datos insuficientes.";
}

// $conexion->close();

// // Redirigir de vuelta a la página del estado del alumno
// header("Location: alumno_estado.php?id=$alumno_id");
exit;
?>
