<?php 
require 'navbar.php';
require '../../conn/connection.php';
require 'functions.php';
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
//--------------------------------------------------------------------------- 
if(isset($_POST['guarda_nota'])){
    $alumno_id = $_POST["alumno_id"];
    $materia_id = $_POST["materia_id"];
    $ciclo_lectivo = $_POST["ciclo_lectivo"];
    $id_examen_tipo = $_POST["id_examen_tipo"];
    $puntaje = $_POST["puntaje"]; 
    $error = "";
    try {
        $sql = "INSERT INTO nota (id_persona, id_materia, id_ciclo, id_examen_tipo, nota) 
                VALUES (:id_persona, :id_materia, :ciclo_lectivo, :id_examen_tipo, :puntaje)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_persona', $alumno_id);
        $stmt->bindParam(':id_materia', $materia_id);            
        $stmt->bindParam(':ciclo_lectivo', $ciclo_lectivo);
        $stmt->bindParam(':id_examen_tipo', $id_examen_tipo);
        $stmt->bindParam(':puntaje', $puntaje);
        if ($stmt->execute()) {
            echo '<script>
                    var msj = "Asistencia registrada correctamente";
                    window.location="alumno_index.php?mensaje="+ msj;
                  </script>';
            exit();
        } else {
            $error = "Error al ingresar nota.";
        }       
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
        // Redirige a alumno_crea.php con el error y datos del formulario
        // $redirect_url = "admin_index.php?error=" . urlencode($error)
        //     . "&nombre=" . urlencode($nombre)
        //     . "&apellido=" . urlencode($apellido)
        //     . "&email=" . urlencode($email);
        // header("Location: " . $redirect_url);
        exit();
    }
}
 //--------------BARRA DE CICLO LECTIVO ACTUAL----------------------  
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
<!-- ------------------------------------------- -->
<?
function existeNota($alumno_id, $id_materia, $db){
    $nota = $db->prepare("select * from nota where id_materia = '$id_materia' and id_alumno = '$alumno_id'");
    $nota->execute();
    //si devuelve una fila significa que la nota ya es
    $nota = $nota->rowCount();
    return $nota;
}
?>
<!-- ------------------------------------- -->
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0 ">    
                    <div class="row">                
                        <h5 class="col"><?php echo htmlspecialchars($nombre_completo); ?></h5>     
                        <div class="col mb-2">
                            <form id="miFormulario" action="" method="post" class="form-inline justify-content-end my-1">
                                <!-- <button type="submit" name="buscar" class="btn btn-light btn border btn-sm ">
                                    <i class="fa-solid fa-magnifying-glass "></i>
                                </button> -->
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
                            </form>
                        </div>             
                    </div>
                </div>
                <!----------------------------------------------------------------->      
                <div class="card-body table-responsive">
                    <table id="" class="table table-bordered table-sm">
                        <thead class="thead-dark">
                            <!-- ------------------------------------------ -->    
                            <tr>        
                                <th id="fixed-size2">id</th>
                                <th id="fixed-size3">Materia</th>             
                                <?php   
                                    $sql_examen = "SELECT * FROM examen ";
                                    $resul_examen = $conexion->query($sql_examen);
                                    $examen = [];
                                    if ($resul_examen->num_rows > 0) {
                                        while ($row = $resul_examen->fetch_assoc()) {
                                            $examen[] = $row;
                                            
                                            echo '<th id="fixed-size">'. $row['nombre_examen'] .'</th>';
                                            $id_examen_tipo=$row['id_examen_tipo'];
                                        }
                                    }
                                ?>                                                               
                                <th id="fixed-size">Guardar</th>
                            </tr>
                        </thead>
                        <!------------------------------------------------------------------->
                        <tbody>                            
                            <?php foreach ($materias as $index => $materia): ?>
                                <tr>
                                    <form action="nota_procesa.php" method="post">
                                        <input type="hidden" name="alumno_id" value="<?php echo htmlspecialchars($alumno_id); ?>">
                                        <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia['id_materia']); ?>">
                                        <input type="hidden" name="ciclo_lectivo" value="<?php echo htmlspecialchars($select_ciclo); ?>">     
                                        <?php $id_materia=$materia['id_materia']; ?>     
                                        <?php echo $id_materia.')'; ?>                              
                                        <!-- ------------------------------------------------------- -->
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($materia['Nombre']); ?></td>
                                        <!-- ------------------------------------------------------- -->
                                        <?php   
                                        for($i = 1; $i < $id_examen_tipo+1; $i++) {
                                                
                                        echo '
                                        <td>
                                        <input class="form-control" id="fixed-size" type="text" type="text" maxlength="5" name="evaluacion' . $i . 'alumno' . $index . '" class="txtnota">
                                        '.$id_materia.'-'.$alumno_id.'-'.$select_ciclo.'-'.$i;
                                        '</td>';
                                    
                                          }
                                        ?>
                                        <!-- <td> 
                                            <input value="" required min="0" name="puntaje" placeholder="Escriba la calificación" class="form-control">
                                            <input size="4" type="text" name="nota1" value="<?php echo $nota1;?>" placeholder="nota" class="form-control">
                                        </td>
                                       -->
                                        <!-- <td><?php echo isset($estado_alumno[$materia['id_materia']]) ? htmlspecialchars($estado_alumno[$materia['id_materia']]) : 'libre'; ?></td> -->
                                        
                                        <td>
                                           <button type="submit" name="guarda_nota" class="btn btn-primary btn-sm" >Guardar</button>
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
