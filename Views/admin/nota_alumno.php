<?php require 'navbar.php';
require '../../conn/connection.php';
// Obtener el ID del alumno de la URL
$alumno_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($alumno_id) {
    $sql_alumno = "SELECT * FROM persona WHERE id_persona = $alumno_id";
    $result_alumno = $conexion->query($sql_alumno);
    if ($result_alumno->num_rows > 0) {
        $alumno = $result_alumno->fetch_assoc();
        $nombre_completo = $alumno['nombre'] . ' ' . $alumno['apellido'];
    } else {
        $nombre_completo = "Alumno no encontrado";
    }
    $sql = "SELECT * FROM materia where estado = 'Activo'";
    $result = $conexion->query($sql);
    $materias = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $materias[] = $row;
        }
    } else {
        echo "No se encontraron materias.";
    }       
}else{
    echo "ID de alumno no especificado."; 
    exit;
}
?>
<!-- ------------------------------------- -->
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0 ">                    
                    <!-- --------------BARRA DE CICLO LECTIVO ACTUAL---------------------- -->
                    <?php 
                        if(!isset($_POST['buscar'])){
                            $sql_ciclo = "SELECT id_ciclo , nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1";
                            $result_ciclo = $conexion->query($sql_ciclo);
                            $ciclo = $result_ciclo->fetch_assoc();
                            $select_ciclo = $ciclo['id_ciclo'];   
                        }
                        if(isset($_POST['buscar'])){
                            if(!empty($_POST['select_ciclo'])){
                                $select_ciclo = $_POST['select_ciclo'];
                                // ----------------------------------------------------                
                                $sql_ciclo = "SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo WHERE id_ciclo = $select_ciclo";
                                $result_ciclo = $conexion->query($sql_ciclo);
                                $ciclo = $result_ciclo->fetch_assoc();
                            }else {
                                $sql_ciclo = "SELECT id_ciclo , nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1";
                                $result_ciclo = $conexion->query($sql_ciclo);
                                $ciclo = $result_ciclo->fetch_assoc();
                                $select_ciclo = $ciclo['id_ciclo'];
                                // ********************************************
                                //LA VARIABLE $select_ciclo LLEVA EL CICLO LECTIVO A TODA LA PAGINA
                                // ********************************************
                            }
                        }
                    ?>            
                    <!-- ------------------------------------------------------------- -->  
                    <div class="row">                
                        <h5 class="col"><?php echo htmlspecialchars($nombre_completo); ?></h5>     
                        <div class="col mb-2">
                            <form action="" method="post" class="form-inline  justify-content-end my-1">
                                <button type="submit" name="buscar" class="btn btn-light btn border btn-sm ">
                                    <i class="fa-solid fa-magnifying-glass "></i>
                                </button>
                                <select name="select_ciclo" class="form-control form-control-sm w-50" >
                                    <option value="" disabled selected class="text-secondary">Ciclo lectivo actual: <?php echo $ciclo['nombre_ciclo']; ?></option>
                                    <?php                          
                                    $stmt = $db->query("SELECT * FROM ciclo_lectivo");                          
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row["id_ciclo"]}'>{$row["nombre_ciclo"]}</option>";
                                    }
                                    ?>
                                </select>
                            </form>
                        </div>             
                    </div>
                </div>
                <!----------------------------------------------------------------->      
                <div class="card-body table-responsive">
                    <table id="example" class="table table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th id="notas">#</th>
                                <th id="notas">Materia</th>
                                <th id="notas">Nota 1</th>
                                <th id="notas">Nota 2</th>
                                <th id="notas">Nota 3</th>
                                <th id="notas">Nota 4</th>
                                <th id="notas" class="border border-dark border-1 border-bottom-0" >Calif. Regular</th>
                                 <!--____________________________
                                <th id="notas">Calif.1° Ex.Final</th>
                                <th id="notas">Calif.2° Ex.Final</th>
                                <th id="notas">Calif. Final</th>
                                <th id="notas">1°PeR. Ev.Dic</th>
                                <th id="notas">2°PeR. Ev.Dic</th>
                                <th id="notas">1°PeR. Ev.Feb</th>
                                <th id="notas">2°PeR. Ev.Feb</th>_____________________-->
                                <th id="notas">Calif. Final</th>
                                <th id="notas">Guardar</th>
                            </tr>
                        </thead>
                        <!--____________________________________________________________-->
                        <tbody>                            
                            <?php foreach ($materias as $index => $materia): ?>
                                <tr>
                                    <form action="" method="post">
                                        <input type="hidden" name="alumno_id" value="<?php echo htmlspecialchars($alumno_id); ?>">
                                        <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia['id_materia']); ?>">
                                        <input type="hidden" name="ciclo_lectivo" value="<?php echo htmlspecialchars($select_ciclo); ?>">
                                        
                                        <!-- -------------CONSULTA PARA BUSCAR NOTA 1 Y LO MUESTRA EN EL "VALUE"
                                         <p>esta vista la puede usar el profesor, por eso los otros campos entan deshabilitados</p>
                                         <p>para modificar los campos dasabilitados usar "Registra una nota"</p>
                                         <p>para ingresar datos en los campos desabilitados se tiene que crear una mesa listar los alumnos y agregar nota </p>
                                        **poner un cliclo o "for" para buscar en la base de datos y listar**
                                        <br>
                                        **************
                                        <?php
                                           $mate=$materia['id_materia'];
                                           $sql_nota = "SELECT nota FROM nota WHERE id_persona = $alumno_id 
                                           AND id_materia = $mate 
                                           AND id_ciclo = $select_ciclo
                                           AND id_examen_tipo id_examen_tipo BETWEEN 1 AND 4 
                                           ";
                                           
                                           $result_nota = $conexion->query($sql_nota);    
                                           $nota1 = $result_nota->fetch_assoc(); 
                                           $nota2 = $result_nota->fetch_assoc(); 
                                    
                                           if(empty($nota1['nota'])){
                                            $nota1=0;
                                           }else{
                                            $nota1= $nota1['nota'];
                                            }                                                                         
                                        ?> 
                                        
                                        <?php echo "bandera ".$alumno_id." ". $mate." ". $select_ciclo." ".$nota1?>
                                        <!-- -------------------------- -->
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($materia['Nombre']); ?></td>
                                        <td> 
                                            <!-- <input value="" required min="0" name="puntaje" placeholder="Escriba la calificación" class="form-control">                                        -->
                                            <input size="4" type="text" name="nota1" value="<?php echo $nota1;?>" placeholder="nota" class="form-control">
                                        </td>
                                        <td>
                                            <input size="4" type="text" name="nota2" value="" placeholder="" class="form-control">
                                        </td>
                                        <td>
                                            <input size="4" type="text" name="nota3" value="" placeholder="" class="form-control">
                                        </td>
                                        <td>
                                            <input size="4" type="text" name="nota4" value="" placeholder="" class="form-control">
                                        </td>
                                        <td class="border border-dark border-1 border-top-0">
                                            <input size="4" type="text" name="" value="" placeholder="" class="form-control" disabled>
                                        </td>
                                         <!--____________________________
                                        <td>
                                            <input size="4" type="text" name="" value="" placeholder="" class="form-control"disabled>
                                        </td>
                                        <td>
                                            <input size="4" type="text" name="" value="" placeholder="" class="form-control"disabled>
                                        </td>
                                        <td>
                                            <input size="4" type="text" name="" value="" placeholder="" class="form-control" disabled>
                                        </td>
                                        <td>
                                            <input size="4" type="text" name="" value="" placeholder="" class="form-control" disabled>
                                        </td>
                                        <td>
                                            <input size="4" type="text" name="" value="" placeholder="" class="form-control" disabled>
                                        </td>
                                        <td>
                                            <input size="4" type="text" name="" value="" placeholder="" class="form-control" disabled>
                                        </td>
                                        <td>
                                            <input size="4" type="text" name="" value="" placeholder="" class="form-control" disabled>
                                        </td>_____________________-->
                                            
                                        <td><?php echo isset($estado_alumno[$materia['id_materia']]) ? htmlspecialchars($estado_alumno[$materia['id_materia']]) : 'libre'; ?></td>
                                        <td>
                                           <button type="submit" class="btn btn-primary btn-sm" >Guardar</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>    
            </div> 
        </div>   
    </div>
</section>
<?php require 'footer.php'; ?>
