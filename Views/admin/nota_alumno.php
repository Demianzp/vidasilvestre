<?php require 'navbar.php';
require '../../conn/connection.php';

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
    $sql = "SELECT m.* FROM alumno_materia am
            JOIN materia m ON am.id_materia = m.id_materia
            WHERE am.id_persona = $alumno_id AND m.estado = 'Activo'";
    $result = $conexion->query($sql);
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
//--------------------------------------------------------------------------- 
function actualizarNota($db, $alumno_id, $materia_id, $ciclo_lectivo, $n1,$n2,$n3,$n4,$n5,$n6,$n7,$n9,$n10,$n11,$n12,$n13) {
    $sql = "UPDATE nota 
        SET n1=:n1,n2=:n2,n3=:n3,n4=:n4,n5=:n5,n6=:n6,n7=:n7,n9=:n9,n10=:n10,n11=:n11,n12=:n12,n13=:n13
        WHERE id_persona = :alumno_id
        AND id_materia = :materia_id
        AND id_ciclo = :ciclo_lectivo";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':n1', $n1);
        $stmt->bindParam(':n2', $n2);
        $stmt->bindParam(':n3', $n3);
        $stmt->bindParam(':n4', $n4);
        $stmt->bindParam(':n5', $n5);
        $stmt->bindParam(':n6', $n6);
        $stmt->bindParam(':n7', $n7);
        $stmt->bindParam(':n9', $n9);
        $stmt->bindParam(':n10', $n10);
        $stmt->bindParam(':n11', $n11);
        $stmt->bindParam(':n12', $n12);
        $stmt->bindParam(':n13', $n13);
        $stmt->bindParam(':alumno_id', $alumno_id); 
        $stmt->bindParam(':materia_id', $materia_id);
        $stmt->bindParam(':ciclo_lectivo', $ciclo_lectivo);
        $stmt->execute();
}
function insertNota($db, $alumno_id, $materia_id, $ciclo_lectivo, $n1, $n2, $n3, $n4, $n5, $n6, $n7, $n9, $n10, $n11, $n12, $n13) {
    $estado = 'activo';
    $sql = "INSERT INTO nota (id_persona, id_materia, id_ciclo, n1, n2, n3, n4, n5, n6, n7, n9, n10, n11, n12, n13, estado) 
            VALUES (:id_persona, :id_materia, :ciclo_lectivo, :n1, :n2, :n3, :n4, :n5, :n6, :n7, :n9, :n10, :n11, :n12, :n13, :estado)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_persona', $alumno_id);
    $stmt->bindParam(':id_materia', $materia_id);
    $stmt->bindParam(':ciclo_lectivo', $ciclo_lectivo);
    $stmt->bindParam(':n1', $n1);
    $stmt->bindParam(':n2', $n2);
    $stmt->bindParam(':n3', $n3);
    $stmt->bindParam(':n4', $n4);
    $stmt->bindParam(':n5', $n5);
    $stmt->bindParam(':n6', $n6);
    $stmt->bindParam(':n7', $n7);
    $stmt->bindParam(':n9', $n9);
    $stmt->bindParam(':n10', $n10);
    $stmt->bindParam(':n11', $n11);
    $stmt->bindParam(':n12', $n12);
    $stmt->bindParam(':n13', $n13);
    $stmt->bindParam(':estado', $estado);
    $stmt->execute();
}
//--------------------------------------------
if(isset($_POST['guarda_nota'])) {
    // ----------------------------------------
    $alumno_id = $_POST["alumno_id"];
    $materia_id = $_POST["materia_id"];
    $ciclo_lectivo = $_POST["ciclo_lectivo"];    
    $n1 = $_POST["n1"]; 
    $n2 = $_POST["n2"]; 
    $n3 = $_POST["n3"]; 
    $n4 = $_POST["n4"]; 
    $n5 = $_POST["n5"]; 
    $n6 = $_POST["n6"];
    $n7 = $_POST["n7"];  
    $n9 = $_POST["n9"]; 
    $n10 = $_POST["n10"]; 
    $n11 = $_POST["n11"]; 
    $n12 = $_POST["n12"];
    $n13 = $_POST["n13"]; 
    $notas = [$n1, $n2, $n3, $n4, $n5, $n6, $n7,$n9, $n10, $n11, $n12, $n13];
    foreach ($notas as &$nota) {
        $nota = !empty($nota) && is_numeric($nota) ? (float)$nota : null;
    }
    list($n1, $n2, $n3, $n4, $n5, $n6, $n7, $n9, $n10, $n11, $n12, $n13) = $notas;

    $error = "";
    // -------------------------------    
    $sql_nota = "SELECT * FROM nota WHERE id_persona = $alumno_id 
                 AND id_materia = $materia_id
                 AND id_ciclo = $ciclo_lectivo";          
    $resul_exa = $conexion->query($sql_nota);
    $nota = $resul_exa->fetch_assoc();    
// --------------CONTROLA EL ENVIO DE FORMULARIO------------------
    if(isset($nota) && $nota['estado'] === 'activo'){ 
        actualizarNota($db, $alumno_id, $materia_id, $ciclo_lectivo, $n1,$n2,$n3,$n4,$n5,$n6,$n7,$n9,$n10,$n11,$n12,$n13);         
    } else {       
        try {  
        insertNota($db, $alumno_id, $materia_id, $ciclo_lectivo, $n1,$n2,$n3,$n4,$n5,$n6,$n7,$n9,$n10,$n11,$n12,$n13);    
        } catch (PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();           
        }
    }
    echo '<script>
            var id_alumno = ' . $alumno_id . ';
            window.location="nota_alumno.php?id="+id_alumno;
          </script>';        
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
                    <table id="" class="table table-striped table-sm">
                        <thead class="thead-dark"> 
                            <tr>        
                                <th id="fixed-size2">id</th>
                                <th id="fixed-size3">Materia</th>             
                                <?php   
                                    $sql_examen = "SELECT * FROM examen WHERE id_examen_tipo <> 8";
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
                                    <form id="miFormulario" action="" method="post">
                                        <input type="hidden" name="alumno_id" value="<?php echo htmlspecialchars($alumno_id); ?>">
                                        <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia['id_materia']); ?>">
                                        <input type="hidden" name="ciclo_lectivo" value="<?php echo htmlspecialchars($select_ciclo); ?>">                                          
                                        <?php $id_materia=$materia['id_materia']; ?>
                                        <!-- ------------------------------------------------------- -->
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($materia['Nombre']); ?></td>
                                        <!-- --------------------- -->
                                         <?php
                                         $mate=$materia['id_materia'];
                                         $sql_nota = "SELECT * FROM nota WHERE id_persona = $alumno_id 
                                         AND id_materia = $mate
                                         AND id_ciclo = $select_ciclo
                                         ";                                           
                                         $result_nota = $conexion->query($sql_nota);    
                                         $nota = $result_nota->fetch_assoc(); 
                                        // -------------------------                                       
                                        if(empty($nota['n1'])){$nota1 =null;}else{$nota1= $nota['n1'];}
                                        if(empty($nota['n2'])){$nota2 =null;}else{$nota2= $nota['n2'];}
                                        if(empty($nota['n3'])){$nota3 =null;}else{$nota3= $nota['n3'];}
                                        if(empty($nota['n4'])){$nota4 =null;}else{$nota4= $nota['n4'];}
                                        if(empty($nota['n5'])){$nota5 =null;}else{$nota5= $nota['n5'];}
                                        if(empty($nota['n6'])){$nota6 =null;}else{$nota6= $nota['n6'];}
                                        if(empty($nota['n7'])){$nota7 =null;}else{$nota7= $nota['n7'];}
                                        // if(empty($nota['n8'])){$nota8 =null;}else{$nota8= $nota['n8'];}
                                        if(empty($nota['n9'])){$nota9 =null;}else{$nota9= $nota['n9'];}
                                       if(empty($nota['n10'])){$nota10=null;}else{$nota10= $nota['n10'];}
                                       if(empty($nota['n11'])){$nota11=null;}else{$nota11= $nota['n11'];}
                                       if(empty($nota['n12'])){$nota12=null;}else{$nota12= $nota['n12'];}                                        
                                       if(empty($nota['n13'])){$nota13=null;}else{$nota13= $nota['n13'];}
                                        // -----------------------------------------------
                                        $notas = [$nota1, $nota2, $nota3, $nota4];
                                        $notas_filtradas = array_filter($notas, function($nota) {
                                            return !is_null($nota) && $nota !== 0 && $nota !== '';
                                        });
                                        if (count($notas_filtradas) > 0) {
                                            $nota5 = array_sum($notas_filtradas) / count($notas_filtradas);
                                        } 
                                        $nota13 = max($nota6, $nota7, $nota9, $nota10, $nota11, $nota12);
                                        if (!($nota13 >= 4)){
                                            $nota13=null;
                                        }
                                        ?>
                                        
                                        <!-- -------------------------------------------------- -->
                                        <td><input id="fixed-size"  name="n1"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota1; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n2"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota2; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n3"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota3; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n4"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota4; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n5"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota5; ?>" placeholder="" class="form-control" readonly></td> 
                                        <td><input id="fixed-size"  name="n6"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota6; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n7"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota7; ?>" placeholder="" class="form-control"></td> 
                                        <!-- <td><input id="fixed-size"  name="n8"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota8; ?>" placeholder="" class="form-control" readonly></td>  -->
                                        <td><input id="fixed-size"  name="n9"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota9; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n10" type="number" min="0" max="10" step="0.1" value="<?php echo $nota10; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n11" type="number" min="0" max="10" step="0.1" value="<?php echo $nota11; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n12" type="number" min="0" max="10" step="0.1" value="<?php echo $nota12; ?>" placeholder="" class="form-control"></td>                                         
                                        <td><input id="fixed-size"  name="n13" type="number" min="0" max="10" step="0.1" value="<?php echo $nota13; ?>" placeholder="" class="form-control" readonly></td> 
                                        <td>
                                            <input type="hidden" name="envio_numero" value="1">
                                            <button type="submit" onclick="enviarDosVeces()" name="guarda_nota" class="btn btn-primary btn-sm" >Guardar</button>
                                        </td>
                                    </form>
                                    <script>
                                        function enviarDosVeces() {
                                            const formulario = document.forms["miFormulario"];

                                            // Primer envío
                                            formulario.submit();
                                        
                                            // Segundo envío después de un breve retraso
                                            setTimeout(() => {
                                                formulario.envio_numero.value = 2; // Cambia el valor para el segundo envío
                                                formulario.submit();
                                            }, 500); // Ajusta el tiempo de retraso si es necesario
                                        }
                                    </script>
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
